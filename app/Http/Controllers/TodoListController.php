<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }

    public function todoList()
    {
        $todoList = $this->todoListService->getTodoList();
        return response()->view('todolist.todolist', [
            'title' => 'Todo List',
            'todoList' => $todoList
        ]);
    }

    public function addTodoList(Request $request)
    {
        # code...
    }

    public function removeTodoList(Request $request, string $todoId)
    {
        # code...
    }
}
