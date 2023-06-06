<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session as FacadesSession;
use Tests\TestCase;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListServiceNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'lisman');

        $todolist = FacadesSession::get('todolist');
        foreach ($todolist as $value) {
            self::assertEquals('1', $value['id']);
            self::assertEquals('lisman', $value['todo']);
        }
    }

    public function getTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function getTodoListNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'lisman'
            ],
            [
                'id' => '2',
                'todo' => 'arsilo'
            ]
        ];

        $this->todoListService->saveTodo('1', 'lisman');
        $this->todoListService->saveTodo('2', 'arsilo');

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo('1', 'lisman');
        $this->todoListService->saveTodo('2', 'arsilo');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('3');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('1');

        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('2');

        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}
