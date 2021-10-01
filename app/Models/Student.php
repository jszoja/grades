<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Student
{
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
        $this->__grade = $this->parseGrade($data['grade']);
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
     * @return int
     */
    public function parseGrade(mixed $grade) : int
    {
        $this->__grade = (int)$grade;
        $this->__pass = $this->__grade >= 35;
        return $grade;
    }


    public function asArray() : array
    {
        return ['name' => $this->__name, 'grade' => $this->__grade, 'pass' => $this->__pass];
    }

}
