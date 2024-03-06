<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;

class WebController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::all();
        return Task::all();
    }

    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Создание новой задачи
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        // Возвращаем успешный ответ
        return response()->json($task, 201);
    }

    public function show($id)
    {
        // Возвращает задачу по заданному ID
        return Task::findOrFail($id);
    }

    // Метод для обновления задачи
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        return response()->json($task, 200);
    }

    // Метод для удаления задачи
    public function destroy($id)
    {
        // Находим задачу по ее ID
        $task = Task::find($id);

        // Проверяем, существует ли задача
        if (!$task) {
            return response()->json(['error' => 'Задача не найдена'], 404);
        }

        // Удаляем задачу
        $task->delete();

        // Возвращаем успешный ответ
        return response()->json(['message' => 'Задача успешно удалена'], 200);
    }

    public function filterByStatus(Request $request, $status)
    {
        $tasks = Task::where('status', $status)->get();
        return response()->json($tasks);
    }
}
