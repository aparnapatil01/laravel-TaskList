<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->get();
        return view('tasks.index', ['tasks'=>$tasks]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    public function destroy($id)
    {
        Log::info("In destroy");
        Task::destroy($id);
        return redirect('/tasks');
    }
}