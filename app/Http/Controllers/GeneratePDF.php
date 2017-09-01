<?php

namespace App\Http\Controllers;

use Fpdf;
use Illuminate\Http\Request;
use QrCode;
use DB;

class GeneratePDF extends Controller
{
	public function show(){
		return view('qr');
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$this->emptyDB();
    	$countQR = $request['countQR'];

        //generateQR();
        //generatePDF();

        return view('qr');
    }

	private function emptyDB(){
		DB::table('game_codes')->delete();
		DB::table('users_codes')->delete();
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
