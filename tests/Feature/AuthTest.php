<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuthTest extends TestCase
{
    //use RefreshDataBase;

    public function testLoginUser()
    {
        $response = $this->post('/api/login', [
            'cpf' => '12345678910',
            'password' => '123456'
        ]);

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertArrayHasKey('token', $response->original['data']);
    }

    public function testLogoutUser()
    {
        $this->post('/api/login', [
            'cpf' => '12345678910',
            'password' => '123456'
        ]);

        $response = $this->get('/api/logout');

        $this->assertEquals($response->getStatusCode(), 200);
    }
    // public function testCreateUser()
    // {
    //     $userData = [
    //         'name' => 'Alexi',
    //         'email' => 'admin@admin.com',
    //         'cpf' => 12345678910,
    //         'password' => bcrypt('123456')
    //     ];

    //     $response = $this->post('/api/usuario');

    //     $response->assertStatus(200);
    // }
}
