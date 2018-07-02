<?php
/**
 * Created by PhpStorm.
 * User: caspa
 * Date: 31.05.2018
 * Time: 12:11.
 */

namespace App\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use jeremykenedy\Uuid\Uuid;
use PDF;
use QrCode;

class GenerateController extends Controller
{
    public function showGenerate()
    {
        return view('leader.generate');
    }

    public function index(Request $request)
    {
        $this->preCleanup();

        $countQR = CodeCount::setCodeCount($request['countQR']);

        for ($i = 0; $i < $countQR; $i++) {
            $code = $this->generateCodes();

            $this->generateQR($code, $i);
        }

        if ($countQR > 0) {
            $this->generatePDF($countQR);
        }

        return back();
    }

    private function preCleanup()
    {
        DB::table('game_codes')->delete();
        DB::table('users_codes')->delete();
        DB::table('game_admin')->delete();

        DB::update('UPDATE users SET rank = NULL;');
        DB::update('UPDATE users SET total_points = NULL;');
        DB::update('UPDATE users SET start = NULL;');
        DB::update('UPDATE users SET end = NULL;');

        File::delete(File::glob(storage_path().'/pdf/codes/..png'));
    }

    private function generateCodes()
    {
        $code = uuid::generate(4);

        DB::table('game_codes')->insert(['game_code' => $code]);

        return $code;
    }

    private function generateQR($code, $QRNumber)
    {
        QrCode::format('png')->size(200)->generate(url('/').'/user/qr/scan/'.$code, storage_path().'/pdf/codes/'.$QRNumber.'.png');
    }

    private function generatePDF($fileCount)
    {
        PDF::SetTitle(config('app.name'));
        PDF::SetFont('Arial', 'B', 18);
        PDF::SetMargins(10, 10, 10);
        PDF::SetCreator(config('app.name'));
        PDF::SetAuthor(config('app.name'));

        for ($i = 0; $i < $fileCount; $i++) {
            $j = $i;
            if ($fileCount - $i == 1) {
                PDF::AddPage();
                PDF::Cell(0, 15, config('app.name').' - QR Nr. '.++$j, 0, 1, 'C');
                PDF::SetY(20);
                PDF::SetX(80);
                PDF::Image(storage_path().'/pdf/codes/'.$i.'.png');
                PDF::SetY(70);
                PDF::SetX(20);
                PDF::Image(storage_path().'/pdf/logo.png');
            } else {
                PDF::AddPage();
                PDF::Cell(0, 15, config('app.name').' - QR Nr. '.++$j, 0, 1, 'C');
                PDF::SetY(20);
                PDF::SetX(80);
                PDF::Image(storage_path().'/pdf/codes/'.$i.'.png');
                PDF::SetY(70);
                PDF::SetX(20);
                PDF::Image(storage_path().'/pdf/logo.png');

                PDF::SetY(130);
                PDF::SetX(0);
                PDF::SetMargins(0, 10, 0);
                PDF::Cell(0, 0, '', 1, 1);
                PDF::SetY(150);

                PDF::AddPage();
                PDF::Cell(0, 15, config('app.name').' - QR Nr. '.++$j, 0, 1, 'C');
                PDF::SetY(160);
                PDF::SetX(80);
                PDF::Image(storage_path().'/pdf/codes/'.$i.'.png');
                PDF::SetY(210);
                PDF::SetX(20);
                PDF::Image(storage_path().'/pdf/logo.png');
            }
        }

        PDF::Output(storage_path().'/pdf/file/QR-Codes.pdf', 'F');
    }
}
