<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class TodoController extends Controller
{
    private $database;
    private $table = 'tasks';

    public function __construct()
{
    $factory = (new Factory)
        ->withServiceAccount(
            storage_path('app/firebase/firebase_credentials.json')
        )
        ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

    $this->database = $factory->createDatabase();
}
    

    public function index()
    {
        $tasks = $this->database
            ->getReference($this->table)
            ->getValue();

        return view('todo', compact('tasks'));
    }

    public function store(Request $request)
    {
        $this->database
            ->getReference($this->table)
            ->push([
                'task' => $request->task
            ]);

        return redirect('/');
    }

    public function delete($id)
    {
        $this->database
            ->getReference($this->table . '/' . $id)
            ->remove();

        return redirect('/');
    }
 
public function update(Request $request, $id)
{
    $this->database->getReference('tasks/' . $id)
        ->update([
            'task' => $request->task
        ]);

    return redirect('/');
}

public function search(Request $request)
{
    $keyword = strtolower($request->search);

    $tasks = $this->database
        ->getReference($this->table)
        ->getValue();

    $results = [];

    if ($tasks) {
        foreach ($tasks as $id => $task) {

            if (str_contains(strtolower($task['task']), $keyword)) {
                $results[$id] = $task;
            }
        }
    }

    return view('todo', [
        'tasks' => $results
    ]);
}
}