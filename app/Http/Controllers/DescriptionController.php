<?php

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
