<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todoList = $this->todoListService->getTodoList();

            return response()->view('todolist.todolist', [
                'title' => 'Todo List',
                'todoList' => $todoList,
                'error' => 'Todo Is Required'
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodoListController::class, 'todoList']);
    }

    public function removeTodoList(Request $request, string $todoId)

    {
        $this->todoListService->removeTodo($todoId);

        return redirect()->action([TodoListController::class, 'todoList']);
    }
}
