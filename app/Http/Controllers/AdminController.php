<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\User;
use App\Models\Action;
use App\Models\Type;
use App\Models\Document;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use function Ramsey\Uuid\v1;

class AdminController extends Controller
{
// Download Reports
    public function downloadReports() {
        $users = User::all();

        foreach ($users as $user) {
            $user->documents_created_count = Document::where('author', $user->name)->count();
            $user->documents_received_count = Document::where('received_by', $user->id)->count();
            $user->documents_released_count = Document::where('released_by', $user->id)->count();
            $user->documents_terminal_count = Document::where('terminal_by', $user->id)->count();
        }

        $pdf = Pdf::loadView('pdf.reports', compact('users'));
        return $pdf->download('Reports'.'_plm_drs.pdf');
    }
// Office CRUD
    public function offices(Request $request) {

        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Office::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
        }

        if ($category) {
            $query->orderBy($category, $order);
        }

        // Count of users for each office
        $query->withCount('users');

        // Fetch all users from the database and use paginate to show 5 user
        $offices = $query->paginate(5);

       return view('admin.offices',compact('offices'));
    }

    public function addOffice(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:25|unique:offices',
        ]);

        // Create a new office in the database
        Office::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        // Redirect back with a success message
        return redirect()->route('admin-offices')->with('success',$request->name.' - '.$request->code.' -> Office Added Successfully!!');
    }

    public function editOffice($id)
    {
        // Find the office by ID
        $office = Office::findOrFail($id);

        // Pass the user to the view for editing
        return view('admin.offices-edit', compact('office'));
    }

    public function updateOffice(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:25|unique:offices,code,' . $id,
        ]);

        // Find the user by ID
        $office = Office::findOrFail($id);

        // Update user information
        $office->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        // Redirect back with a success message
        return redirect()->route('admin-offices')->with('success',$request->name.' - '.$request->code.' - '.$office->created_at->format('Y-m-d H:i:s').' - '.$office->updated_at->format('Y-m-d H:i:s').' -> Office Updated Successfully!!');
    }

    public function deleteOffice($id)
    {
        // Find the user by ID and delete
        Office::findOrFail($id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Office Deleted Successfully!!');
    }
// User CRUD
    public function users(Request $request) {

        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = User::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereHas('office', function ($query) use ($search) {
                     $query->where('code', 'LIKE', "%{$search}%");
                  })
                  ->orWhere(function ($query) use ($search) {
                     $query->where('role', 0)
                            ->whereRaw("'Administrator' LIKE ?", ["%{$search}%"])
                     ->orWhere(function ($query) use ($search) {
                          $query->where('role', 1)
                                ->whereRaw("'Regular User' LIKE ?", ["%{$search}%"]);
                     });
                  });
        }

        if ($category) {
            $query->orderBy($category, $order);
        }

        // Fetch all users from the database and use paginate to show 5 user
        $users = $query->paginate(5);
        $offices = Office::all();

       return view('admin.users',compact('users','offices'));
    }

    public function addUser(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'office_id' => 'required|integer',
            'messenger_color' => 'nullable|string',
        ]);
        // Determine the role string based on the role value
        $roleString = $request->role == 0 ? 'Administrator' : 'Regular User';
        // Fetch the office object using the office_id
        $office = Office::find($request->office_id);
        // Create a new user in the database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'office_id' => $request->office_id,
            'messenger_color' => '#000000',
        ]);
        // Redirect back with a success message
        return redirect()->route('admin-users')->with('success',$request->name.' - '.$request->email.' - '.$roleString.' - '.$office->code.' -> User Added Successfully!!');
    }

    public function editUser($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);
        $offices = Office::all();

        // Pass the user to the view for editing
        return view('admin.users-edit', compact('user','offices'));
    }

    public function updateUser(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|string|unique:users,email,' . $id,
            'password' => 'required|string|min:8',
            'office_id' => 'required|integer',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);
        // Fetch the office object using the office_id
        $office = Office::find($request->office_id);
        // Determine the role string based on the role value
        $roleString = $request->role == 0 ? 'Administrator' : 'Regular User';

        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'office_id' => $request->office_id,
        ]);

        // Redirect back with a success message
        return redirect()->route('admin-users')->with('success',$request->name.' - '.$request->email.' - '.$roleString.' - '.$office->code.' - '.$user->created_at->format('Y-m-d H:i:s').' - '.$user->updated_at->format('Y-m-d H:i:s').' -> User Updated Successfully!!');
    }

    public function deleteUser($id)
    {
        // Find the user by ID and delete
        User::findOrFail($id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User Deleted Successfully!!');
    }

// Tracking Documents
    public function track(Request $request){
        return view('admin.track');
    }

    public function track_docs(Request $request) {
        $trackingNumber = $request->input('tracking_number');
        $document = Document::where('tracking_number', $trackingNumber)->first();
        if (!$document) {
            return redirect()->route('admin-track')->with('error', 'Document not found');
        }

        return view('admin.track-docs', ['document' => $document, 'paperTrails' => $document->paperTrails]);
    }
// Document Types CRUD
    public function types(Request $request) {

        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Type::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        }

        if ($category) {
            $query->orderBy($category, $order);
        }

        // Fetch all users from the database and use paginate to show 5 user
        $types = $query->paginate(5);

        return view('admin.types',compact('types'));
    }

    public function addType(Request $request) {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50|unique:types',
            'description' => 'required|string|max:255',
        ]);

        // Create a new office in the database
        Type::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        // Redirect back with a success message
        return redirect()->route('admin-types')->with('success',$request->name.' - '.$request->description.' - '.' -> Document Type Added Successfully!!');
    }

    public function editType($id)
    {
        // Find the office by ID
        $type = Type::findOrFail($id);

        // Pass the user to the view for editing
        return view('admin.types-edit', compact('type'));
    }

    public function updateType(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50|unique:actions,name,' . $id,
            'description' => 'string|max:255',
        ]);

        // Find the user by ID
        $type = Type::findOrFail($id);

        // Update user information
        $type->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect back with a success message
        return redirect()->route('admin-types')->with('success',$request->name.' - '.$request->description.' - '.$type->created_at->format('Y-m-d H:i:s').' - '.$type->updated_at->format('Y-m-d H:i:s').' -> Document Type Updated Successfully!!');
    }

    public function deleteType($id)
    {
        // Find the user by ID and delete
        Type::findOrFail($id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Document Type Deleted Successfully!!');
    }
// Document Actions CRUD
    public function actions(Request $request) {

        $search = $request->input('search');
        $category = $request->input('category');
        $order = $request->input('order');

        $query = Action::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        if ($category) {
            $query->orderBy($category, $order);
        }

        // Fetch all users from the database and use paginate to show 5 user
        $actions = $query->paginate(5);

        return view('admin.actions',compact('actions'));
    }

    public function addAction(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50|unique:actions',
            'description' => 'required|string|max:255',
        ]);

        // Create a new office in the database
        Action::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        // Redirect back with a success message
        return redirect()->route('admin-actions')->with('success',$request->name.' - '.$request->description.' - '.' -> Document Action Added Successfully!!');
    }

    public function editAction($id)
    {
        // Find the office by ID
        $action = Action::findOrFail($id);

        // Pass the user to the view for editing
        return view('admin.actions-edit', compact('action'));
    }

    public function updateAction(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:50|unique:actions,name,' . $id,
            'description' => 'string|max:255',
        ]);

        // Find the user by ID
        $action = Action::findOrFail($id);

        // Update user information
        $action->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect back with a success message
        return redirect()->route('admin-actions')->with('success',$request->name.' - '.$request->description.' - '.$action->created_at->format('Y-m-d H:i:s').' - '.$action->updated_at->format('Y-m-d H:i:s').' -> Document Action Updated Successfully!!');
    }

    public function deleteAction($id)
    {
        // Find the user by ID and delete
        Action::findOrFail($id)->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Document Action Deleted Successfully!!');
    }
// Configurations
    public function configs() {
        return view('admin.configs');
    }
// System Logs
    public function logs(Request $request) {

        $category = $request->input('category');
        $order = $request->input('order');
        $datetime = $request->input('datetime');


        $query = Notification::query();


        if ($datetime) {
            $datetime = Carbon::parse($datetime)->format('Y-m-d H:i:s');
            // Use the correct column name 'triggered_at' here
            $query->where('triggered_at', '>=', $datetime);
        }

        if ($category && in_array($category, ['user_id', 'triggered_at'])) {
            $query->orderBy($category, $order);
        }

        $notifications = $query->paginate(10);

        return view('admin.logs', compact('notifications'));
    }
// DRS Guide
    public function guides() {
        return view('admin.guides');
    }

}
