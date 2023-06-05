<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // Cek Page
    public function testLoginPage()
    {
        $this->get('/login')->assertSeeText('Login');
    }


    // Cek data benar, redirect ke halaman '/', sessionnya sesuai
    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'lisman',
            'password' => '12345'
        ])->assertRedirect('/')->assertSessionHas('user', 'lisman');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession(['user' => 'lisman'])->get('/login')->assertRedirect('/');
    }

    // Cek login member
    public function testLoginPageForMember()
    {
        $this->withSession(['user' => 'lisman'])->get('/login')->assertRedirect('/');
    }


    // Cek ketika tidak mengirimkan data
    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText('User and password is required');
    }

    // Cek ketika data salah
    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or password is wrong');
    }

    // Cek 
    public function testLogout()
    {
        $this->withSession(['user' => 'lisman'])
            ->post('/logout')->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')->assertRedirect('/login');
    }
}
