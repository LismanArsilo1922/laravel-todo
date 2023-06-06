<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            'user' => 'lisman',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'lisman'
                ]
            ]
        ])->get('/todolist')->assertSeeText('1')->assertSeeText('lisman');
    }
}
