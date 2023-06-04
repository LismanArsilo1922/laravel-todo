<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
  private UserService $userService;

  protected function setUp(): void
  {
    parent::setUp();

    $this->userService = $this->app->make(UserService::class);
  }

  public function testLoginSuccess()
  {
    self::assertTrue($this->userService->login('lisman', '12345'));
  }

  public function testLoginNotFound()
  {
    self::assertFalse($this->userService->login('luluk', '12345'));
  }

  public function testLoginWrongPassword()
  {
    self::assertFalse($this->userService->login('lisman', '123'));
  }
}
