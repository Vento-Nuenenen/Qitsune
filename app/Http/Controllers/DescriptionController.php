<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    public function showDescription(){
		return view('user.description');
    }
}
