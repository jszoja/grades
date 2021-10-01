<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GradesController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
  {


      $data = [];
      $students = $request->json();

     if( $students->count() < 1 ) {
         //Validator::make(['row' => []],['row' => 'array|min:1'])->validate();
         return response()
             ->json(['error' => 'Unsupported json format'])
             ->setStatusCode(400);
     }



      foreach($students as $i => $student ) {
          $studentRecord = new Student($student);
          $data[] = $studentRecord->asArray();
      }

      return response()->json($data);
  }
}
