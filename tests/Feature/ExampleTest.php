<?php

namespace Tests\Feature;

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


}
