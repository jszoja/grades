<?php

namespace App\Http\Controllers;

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

//        var_dump($request->json());

      foreach( $request->json() as $i => $student ) {
          $validator = Validator::make($student,[
              'name'    => 'required|string',
              'grade'   => 'required|numeric|min:0|max:125'
          ],[ 'grade' => 'ggg' ]);

            try {
                $validator->validate();
            } catch (ValidationException $e) {
                $validator->errors()->merge(['row' => $i+1]);
                throw $e;
            }


      }

      $data = [];
      foreach ($request->json() as $student) {
          $data[] = $student;
      }

      return response()->json($data);
  }
}
