<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class TestApiController extends Controller
{
    
    public function test(Request $request){
    	$katakunci = $request->get('katakunci');
    	$data = Student::where('nama','like','%'. $katakunci .'%')->paginate(10); //pemanggilan data dati table "students" dengan menggunakan halaman, perhalamanya adalah 1 item
        return $data; //isi dari $data kita munculkan di response api nya
    }
}
