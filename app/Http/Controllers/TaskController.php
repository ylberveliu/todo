<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Auth;
use App\Task;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ( Task::create($data) )
            return redirect()->route('tasks.index')->with('status', 'Task was created successfully.');
        else
            return redirect()->route('tasks.index')->with('status', 'Opsss! Something want wrong!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit')->with('task', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|min:5'
        ]);

        if ( $task->update(['title' => $request['title']]) )
            return redirect()->route('tasks.index')->with('status', 'Task was updated successfully.');
        else
            return redirect()->route('tasks.index')->with('status', 'Opsss! Something want wrong!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ( $task->delete() )
            return redirect()->route('tasks.index')->with('status', 'Task was deleted successfully.');
        else
            return redirect()->route('tasks.index')->with('status', 'Opsss! Something want wrong!');
    }

    public function done(Task $task)
    {
        if ( $task->update(['status' => 1]) )
            return redirect()->route('tasks.index')->with('status', 'Task was completed successfully.');
        else
            return redirect()->route('tasks.index')->with('status', 'Opsss! Something want wrong!');
    }
}
