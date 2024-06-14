<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    function testRegisterSuccess()
    {
        $this->post('/api/user', [
            'nama' => 'Eko Kurniawan Khannedy',
            'email' => 'khannedy18a578@gmail.com',
            'password' => 'rahasiadonk',
            'nomor_telepon' => '087656787354',
            'alamat' => 'jalan glory no 23'
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    'nama' => 'Eko Kurniawan Khannedy',
                    'email' => 'khannedy18a578@gmail.com',
                    'nomor_telepon' => '087656787354',
                    'alamat' => 'jalan glory no 23'
                ]
            ]);
    }

    function testRegisterFailed()
    {
        $this->post('/api/user', [
            'nama' => '',
            'email' => ' ',
            'password' => '',
            'nomor_telepon' => '',
            'alamat' => ''
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'nama' => [
                        "The nama field is required."
                    ],
                    'email' => [
                        "The email field is required."
                    ],
                    'password' => [
                        "The password field is required."
                    ],
                    'nomor_telepon' => [
                        "The nomor telepon field is required."
                    ],
                    'alamat' => [
                        "The alamat field is required."
                    ]
                ]
            ]);
    }

    function testRegisterEmailAlreadyExist()
    {
        $this->testRegisterSuccess();
        $this->post('/api/user', [
            'nama' => 'Eko Kurniawan Khannedy',
            'email' => 'khannedy18a578@gmail.com',
            'password' => 'rahasiadonk',
            'nomor_telepon' => '087656787354',
            'alamat' => 'jalan glory no 23'
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    'email' => [
                        "email already registered"
                    ]
                ]
            ]);
    }

    public function testLoginSuccess()
    {
        $this->testRegisterSuccess();
        $this->post('/api/user/login', [
            'email' => 'khannedy18a578@gmail.com',
            'password' => 'rahasiadonk'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'nama' => 'Eko Kurniawan Khannedy',
                    'email' => 'khannedy18a578@gmail.com',
                    'nomor_telepon' => '087656787354',
                    'alamat' => 'jalan glory no 23'
                ]
            ]);

        $user = User::where('email', 'khannedy18a578@gmail.com')->first();
        self::assertNotNull($user->remember_token);
    }

    public function testLoginFailedUsernameNotFound()
    {
        $this->post('/api/user/login', [
            'email' => 'test',
            'password' => 'test'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => [
                        "email or password wrong"
                    ]
                ]
            ]);
    }

    public function testLoginFailedPasswordWrong()
    {
        $this->testRegisterSuccess();
        $this->post('/api/user/login', [
            'email' => 'khannedy18a578@gmail.com',
            'password' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => [
                        "email or password wrong"
                    ]
                ]
            ]);
    }

    public function testGetSuccess()
    {
        $this->get('/api/user', [
            'Authorization' => '5RuBaElGsz'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1536,
                    'nama' => 'Ananto Saputro',
                    'email' => 'anantosaputro264@gmail.com',
                    'nomor_telepon' => '(0486) 657 2682',
                    'alamat' => 'Jalan Sentot Alibasa No. 83, Semarang, Bali 03220',
                    'remember_token' => '5RuBaElGsz'
                ]
            ]);
    }

    public function testGetUnauthorized()
    {
        $this->get('/api/user')
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
                ]
            ]);
    }

    public function testGetInvalidToken()
    {
        $this->get('/api/user', [
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
                ]
            ]);
    }

    public function testLogoutFailed()
    {
        $this->delete(uri: '/api/user/logout', headers: [
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ]);
    }
}
