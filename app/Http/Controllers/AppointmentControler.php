<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentControler extends Controller
{
    public function index()
    {
        return view('user.find-doctor');
    }
}