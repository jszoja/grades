<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class Student
{
    const PASS_GRADE = 35;
    /**
     * @var int count student records passed
     */
    static public int $counter = 0;

    private string $__name;
    private int $__grade;
    private bool $__pass;

    private array $__validationRules = [
        'name'    => 'required|string',
        'grade'   => 'required|numeric|min:0|max:100'
    ];

    /**
     * @throws ValidationException
     */
    public function __construct($data)
    {
        self::$counter++;
        $this->__validate($data);
        $this->__name = $data['name'];
        $this->parseGrade($data['grade']);
    }

    /**
     * @throws ValidationException
     */
    private function __validate($data)
    {
        $validator = Validator::make($data, $this->__validationRules);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $validator->errors()->merge(['row' => self::$counter]);
            throw $e;
        }
    }

    /**
     *
     * @param mixed $grade
     * @return void
     */
    public function parseGrade(mixed $grade)
    {
        $this->__grade = (int)$grade;
        $this->__pass = $this->__grade >= self::PASS_GRADE;

        if( $this->__pass) {
            $this->__grade = static::roundGrade($this->__grade);
        }

    }

    /**
     * If the difference between the grade and the next multiple of 5 is less than 3,
     * round grade up to the next multiple of 5
     *
     * @param int $grade
     * @return int
     */
    public static function roundGrade(int $grade) : int
    {
        $rest = $grade % 5;
        if($rest >= 3) {
            return $grade+(5-$rest);
        }

        return $grade;
    }


    /**
     * Return parsed student data as associative array
     *
     * @return array
     */
    #[ArrayShape(['name' => "mixed|string", 'grade' => "int", 'pass' => "bool"])]
    public function asArray() : array
    {
        return ['name' => $this->__name, 'grade' => $this->__grade, 'pass' => $this->__pass];
    }

}
