<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GradesController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Request $request) : JsonResponse
  {

      $data = [];
      foreach( $request->json() as $i => $student ) {
          $studentRecord = new Student($student);
          $data[] = $studentRecord->asArray();
      }

      return response()->json($data);
  }
}
