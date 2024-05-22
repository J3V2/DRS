<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class PdfController extends Controller
{
    public function index() {
        return view('pdf.index');
    }

    public function upload(Request $request) {
        $request->validate(['pdf' => 'required|file|mimes:pdf']);

        // Generate PDF using SnappyPdf
        $pdf = PDF::loadFile($request->file('pdf'));

        // Save PDF to storage
        $pdfPath = 'pdfs/' . time() . '.pdf';
        $pdf->save(storage_path('app/' . $pdfPath));

        // Return URL to the generated PDF
        return response()->json(['url' => asset('storage/' . $pdfPath)], 200);
    }

    public function edit(Request $request) {
        $request->validate(['pdf_url' => 'required', 'edits' => 'required|array']);

        $pdf = PDF::loadFile($request->pdf_url);

        foreach ($request->edits as $edit) {
            // Apply edits to the PDF
            // Example: $pdf->setText($edit['x'], $edit['y'], $edit['text']);
        }

        $outputPath = storage_path('app/public/edited.pdf');
        $pdf->save($outputPath);

        return response()->json(['url' => asset('storage/edited.pdf')], 200);
    }
}
