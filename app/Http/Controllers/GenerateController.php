<?php

namespace App\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use jeremykenedy\Uuid\Uuid;
use PDF;
use QrCode;

class GenerateController extends Controller
{
    /**
     * Defualt-View anzeigen.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGenerate()
    {
        return view('leader.generate');
    }

    /**
     * Code-Generierung initiieren.
     *
     * @param Request $request
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $this->preCleanup();

        $countQR = CodeCount::setCodeCount($request['countQR']);

        for ($i = 0; $i < $countQR; ++$i) {
            $code = $this->generateCodes();

            $this->generateQR($code, $i);
        }

        if ($countQR > 0) {
            $this->generatePDF($countQR);
        }

        return back();
    }

    /**
     * Alte Daten löschen.
     */
    private function preCleanup()
    {
        DB::table('game_codes')->delete();
        DB::table('users_codes')->delete();

        DB::update('UPDATE users SET rank = NULL;');
        DB::update('UPDATE users SET total_points = NULL;');
        DB::table('game_admin')->delete();

        File::delete(File::glob(storage_path().'/pdf/codes/*.png'));
    }

    /**
     * UUIDs für die QR-Codes generieren.
     *
     * @throws \Exception
     *
     * @return mixed
     */
    private function generateCodes()
    {
        $code = uuid::generate(4);

        DB::table('game_codes')->insert(['game_code' => $code]);

        return $code;
    }

    /**
     * QR-Codes generieren.
     *
     * @param $code
     * @param $QRNumber
     */
    private function generateQR($code, $QRNumber)
    {
        QrCode::format('png')->size(200)->generate(url('/').'/user/qr/scan/'.$code, storage_path().'/pdf/codes/'.$QRNumber.'.png');
    }

    /**
     * PDF-File generieren.
     *
     * @param $fileCount
     */
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

                PDF::Cell(0, 15, config('app.name').' - QR Nr. '.++$j, 0, 1, 'C');
                PDF::SetY(160);
                PDF::SetX(80);
                PDF::Image(storage_path().'/pdf/codes/'.++$i.'.png');
                PDF::SetY(210);
                PDF::SetX(20);
                PDF::Image(storage_path().'/pdf/logo.png');
            }
        }

        PDF::Output(storage_path().'/pdf/file/QR-Codes.pdf', 'F');
    }
}
