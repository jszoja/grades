<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesApplication;
use Tests\TestCase;

class ExampleTest extends TestCase
{
//    use CreatesApplication;


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_ok()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->postJson('/api/grades',[
            [ "name" => "John", "grade" => 53 ],
            [ "name" => "Jane", "grade" => 68 ],
            [ "name" => "Emma", "grade" => 32 ],
            [ "name" => "Sophia", "grade" => 39 ],
            [ "name" => "Tom", "grade" => 60 ],
            [ "name" => "Caroline", "grade" => 57 ],
            [ "name" => "Helen", "grade" => 45],
        ]);

        $expected = [
            [ "name" => "John", "grade" => 55 , "pass" => true],
            [ "name" => "Jane", "grade" => 70 , "pass" => true],
            [ "name" => "Emma", "grade" => 32 , "pass" => false],
            [ "name" => "Sophia", "grade" => 40 , "pass" => true],
            [ "name" => "Tom", "grade" => 60 , "pass" => true],
            [ "name" => "Caroline", "grade" => 57 , "pass" => true],
            [ "name" => "Helen", "grade" => 45, "pass" => true],
        ];

        $response->assertJson($expected);

        $response->assertStatus(200);
    }

    public function test_failed_json()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->post('/api/grades', ['wrong']);

        $response->assertJson(['error' => 'Unsupported json format']);
        $response->assertStatus(400);

    }

    public function test_wrong_format()
    {
        $user = User::where('id',1)->first();
        $token = $user->createToken('mytoken')->plainTextToken;

        Student::$counter=0;
        $response = $this->postJson('/api/grades', [
            [ "name" => "John", "grade" => 200 ]
        ], ['Authorization' => 'Bearer '.$token]);

        $response->assertStatus(422);
        $response->assertJson(json_decode(
            '{"errors":{"grade":["The grade must not be greater than 100."],"row":1},"message":"The given data was invalid."}',
            true
        ));
    }

    public function test_logout()
    {
        $user = User::where('id',1)->first();
        $token = $user->createToken('mytoken')->plainTextToken;

        $response = $this->postJson('/api/logout', [
            [ "name" => "John", "grade" => 200 ]
        ], ['Authorization' => 'Bearer '.$token]);

        $response->assertStatus(200);
        $response->assertSee('Successfully logged out');
    }


}
