<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $tasks = Task::all();

       return view('task.index', ['tasks'=>$tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date'
        ]);
        //return redirect->back()->withErrros()->inputs()
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
            'user_id' => 1
        ]); 

        //return $task; 

        // return redirect()->route('task.index');

        return redirect()->route('task.show', $task->id)->withSuccess('Task created with success!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('task.edit', ['task'=>$task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
         
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date'
        ]);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('task.show', $task->id)->withSuccess('Task updated with success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->withSuccess('Task '.$task->id.' deleted with success!');
    }
}
