<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        $data = Student::where('id','>=', 1)->orderBy('id', 'asc')->limit(5)->get();
        
        return view('students.index', ['students' => $data]);
    }
    public function show(){
        
    }
}
