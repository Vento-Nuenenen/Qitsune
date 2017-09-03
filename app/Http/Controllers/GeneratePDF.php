<?php

namespace App\Http\Controllers;

use DB;
use Fpdf;
use Illuminate\Http\Request;
use QrCode;
use uuid;
use Storage;
use File;
use Response;

class GeneratePDF extends Controller
{
    public function show()
    {
        return view('qr');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->preCleanup();

        $countQR = $request['countQR'];

        for($i = 0;$i < $countQR; ++$i){
	        $code = $this->generateCodes();

	        $this->generateQR($code,$i);
        }

        $fileCount = glob(storage_path().'/pdf/QRCodes/*.png');
        if($fileCount > 0){
	       $this->generatePDF($fileCount);
        }

        return view('qr');
    }

    private function preCleanup()
    {
        DB::table('game_codes')->delete();
        DB::table('users_codes')->delete();

	    File::delete(File::glob(storage_path().'/pdf/QRCodes/*.png'));
    }

    private function generateCodes(){
		$code = uuid::generate(4);

		DB::table('game_codes')->insert(['game_code' => $code]);

		return $code;
    }

    private function generateQR($code, $QRNumber)
    {
        QrCode::format('png')->size(200)->generate(url('/').'/qr?code='.$code, storage_path().'/pdf/QRCodes/'.$QRNumber.'.png');
    }

    private function generatePDF($fileCount)
    {
	    Fpdf::SetTitle(config('app.name'));
        Fpdf::SetFont('Arial', 'B', 18);
        Fpdf::SetMargins(10, 10, 10);
        Fpdf::SetCreator(config('app.name'));
        Fpdf::SetAuthor(config('app.name'));

        $fileCount = count($fileCount);

        for($i = 0; $i < $fileCount; $i += 2){
	        $j = $i;
        	if($fileCount - $i == 1){
		        Fpdf::AddPage();
		        Fpdf::Cell(0,15,config('app.name').' - QR Nr. '.$j += 1,0,1,'C');
		        Fpdf::SetX(500);
		        Fpdf::Image(storage_path().'/pdf/QRCodes/'.$i.'.png',Fpdf::GetX() + 1, Fpdf::GetY() + 1);
		        Fpdf::Image(storage_path().'/pdf/Logo-Nuenenen.png',Fpdf::GetX() + 1, Fpdf::GetY() + 50);
	        }else{
		        Fpdf::AddPage();
		        Fpdf::Cell(0,15,config('app.name').' - QR Nr. '.$j += 1,0,1,'C');
		        Fpdf::Image(storage_path().'/pdf/QRCodes/'.$i.'.png',Fpdf::GetX() + 1, Fpdf::GetY() + 1);
		        Fpdf::Image(storage_path().'/pdf/Logo-Nuenenen.png',Fpdf::GetX() + 1, Fpdf::GetY() + 50);
		        Fpdf::SetY(130);
		        Fpdf::Cell(0,15,config('app.name').' - QR Nr. '.$j += 1,0,1,'C');
		        Fpdf::Image(storage_path().'/pdf/QRCodes/'.++$i.'.png',Fpdf::GetX() + 1, Fpdf::GetY() + 1);
		        Fpdf::Image(storage_path().'/pdf/Logo-Nuenenen.png',Fpdf::GetX() + 1, Fpdf::GetY() + 50);
	        }
        }

	    //Fpdf::Output(storage_path().'/pdf/generated/QR-Codes.pdf','F');
		Fpdf::Output();

	    //header("Content-Description: File Transfer");
	    //header("Content-Type: application/pdf");
	    //header("Content-Disposition: attachment; filename='" . 'QR-Codes.pdf' . "'");

	    //readfile(storage_path().'/pdf/generated/QR-Codes.pdf');
    }
}
