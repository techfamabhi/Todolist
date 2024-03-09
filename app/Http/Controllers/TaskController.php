<?php

namespace App\Http\Controllers;
use App\Models\tasks;

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
        $tasks = tasks::all(); 
        $count = $tasks->count();
        return view('frontend.index', compact('tasks', 'count'));
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.index');
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
            'title' => 'required',
          
        ]);
        
        tasks::create($request->post());
 
        return redirect()->route('tasks.index')->with('success','Task Created successfully.');
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
    $task = tasks::findOrFail($id);
    return view('frontend.index', compact('task'));
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
    $task = tasks::findOrFail($id);
    $request->validate([
        'title' => 'required',
    ]);
    
    $task->update($request->all()); 

    return redirect()->route('tasks.index')->with('success', 'Task has been updated successfully');
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = tasks::findOrFail($id);
        $task->delete(); // Delete the task
        return redirect()->route('tasks.index')->with('success', 'Task has been deleted successfully');
    }
    
    public function deleteAll()
    {
        //echo "Test";
        
        tasks::truncate(); 
        return redirect()->route('tasks.index')->with('success', 'All tasks have been deleted successfully');
        
    }
    
    
}
