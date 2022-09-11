<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index()
    {
        return view('auth.selection');
    }

    public function dashboard()
    {



        $students = Student::with(['grade','classroom','section','section'])->get();




        return view('dashboard',compact('students'));
    }
}
