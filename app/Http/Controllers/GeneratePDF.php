<?php

namespace App\Http\Controllers;

use Fpdf;
use QrCode;

class GeneratePDF extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->generateQR();

        return view('qr');
    }

    private function generateQR($codeKey = 'https://pfadi-nuenenen.ch/', $QRNumber = 'Test')
    {
        QrCode::generate($codeKey, storage_path().'/pdf/QRCodes/'.$QRNumber.'.svg');
    }

    private function generatePDF()
    {
        Fpdf::AddPage();
        Fpdf::SetTitle(config('app.name'));
        Fpdf::SetFont('Arial', 'B', 18);
        Fpdf::SetMargins(10, 10, 10);
        Fpdf::SetCreator(config('app.name'));
        Fpdf::SetAuthor(config('app.name'));

        Fpdf::Cell(0, 25, config('app.name').' - QR Nr. 1', 1, 1, 'C');
        Fpdf::AddPage();
        Fpdf::SetFont('Courier', 'B', 18);
        Fpdf::Cell(50, 25, 'Hello World!');
        Fpdf::Output();
        exit;
    }
}
