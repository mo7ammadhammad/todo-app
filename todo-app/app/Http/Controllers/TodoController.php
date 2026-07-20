<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodoController extends Controller
{
    protected $firebaseUrl;

    public function __construct()
    {
        $this->firebaseUrl = rtrim(env('FIREBASE_URL'), '/');
    }

    private function getUserId()
    {
        if (!session()->has('firebase_user_id')) {
            abort(401, 'غير مصرح لك بالوصول.');
        }
        return session('firebase_user_id');
    }

    public function index(Request $request)
    {
        $userId = $this->getUserId();
        $response = Http::get("{$this->firebaseUrl}/users/{$userId}/tasks.json");
        $tasks = $response->json() ?? [];

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            $tasks = array_filter($tasks, function($task) use ($search) {
                return str_contains(strtolower($task['task']), $search);
            });
        }

        return view('todo', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate(['task' => 'required|string']);
        $userId = $this->getUserId();

        Http::post("{$this->firebaseUrl}/users/{$userId}/tasks.json", [
            'task' => $request->task,
            'created_at' => now()->toIso8601String()
        ]);

        return redirect()->back()->with('success', 'تم إضافة المهمة بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['task' => 'required|string']);
        $userId = $this->getUserId();

        Http::patch("{$this->firebaseUrl}/users/{$userId}/tasks/{$id}.json", [
            'task' => $request->task
        ]);

        return redirect()->route('todo.index')->with('success', 'تم تحديث المهمة!');
    }

    public function destroy($id)
    {
        $userId = $this->getUserId();
        Http::delete("{$this->firebaseUrl}/users/{$userId}/tasks/{$id}.json");

        return redirect()->back()->with('success', 'تم حذف المهمة!');
    }
}