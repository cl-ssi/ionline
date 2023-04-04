<?php

namespace App\Http\Controllers\Programmings;

use App\Http\Controllers\Controller;
use App\Models\Indicators\Value;
use App\Models\Programmings\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Task::create($request->all());
        $activity = Value::with('tasks')->findOrFail($request->activity_id);
        if($activity->tasks && $activity->tasks->count() >= $activity->value){
            $activity->update(['value' => $activity->tasks->count()]);
        }
        session()->flash('success', 'Se ha creado una nueva tarea para la actividad programada.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::with('activity', 'reschedulings')->findOrFail($id);
        return view('programmings.participation.task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Task::findOrFail($id)->update($request->all());
        session()->flash('success', 'Se ha editado correctamente la tarea para la actividad programada.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        $activity = Value::with('tasks')->findOrFail($task->activity_id);
        if($activity->tasks && $activity->tasks->count()+1 >= $activity->value){
            $activity->update(['value' => $activity->tasks->count()]);
        }
        session()->flash('success', 'Se ha eliminado correctamente la tarea para la actividad programada.');
        return redirect()->back();
    }
}
