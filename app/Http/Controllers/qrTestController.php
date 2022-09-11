<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\parCode;
class qrTestController extends Controller
{
    public function post(Request $request){
//  return $request;
        $name = $request->name;
        $body = $request->body;


        return view('test_pg', compact('body'));

    }
    public function ScanDode($token){
   $parcodes =   parCode::all();
   foreach ($parcodes as  $parcode){
   $parcode->qr;

  if( $parcode->qr== $token){
            return '<div class="alert alert-primary" role="alert">
       هذا الطالب حاضر
          </div>';
  }
 }


    }
}
