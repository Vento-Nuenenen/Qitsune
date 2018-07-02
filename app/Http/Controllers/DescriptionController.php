<?php
/**
 * Created by PhpStorm.
 * User: caspa
 * Date: 31.05.2018
 * Time: 12:09.
 */

namespace App\Http\Controllers;

class DescriptionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDescription()
    {
        return view('user.description');
    }
}
