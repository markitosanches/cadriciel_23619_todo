<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TaskController extends Controller
{

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //if(Auth::check()){
            $tasks = Task::all();
            return view('task.index', ['tasks'=>$tasks]);
       //}

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = new Category();
        // $categories = $categories->categories();

        $categories = Category::categories();

        //return $categories;

        //return view('task.create', ["categories" => $categories]);

        return view('task.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'min:2|max:45',
            'description' => 'required',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
            'category_id' => 'required'
        ]);
        //return redirect->back()->withErrros()->inputs()

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
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
        $categories = Category::categories();
        return view('task.edit', compact('task', 'categories'));
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
            'due_date' => 'nullable|date',
            'category_id' => 'required'
        ]);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('task.show', $task->id)->withSuccess('Task updated with success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete-task');
        $task->delete();
        return redirect()->route('task.index')->withSuccess('Task '.$task->id.' deleted with success!');
    }

    public function completed($completed){
        
        $tasks = Task::where('completed', $completed)->get();
        return view('task.index', ['tasks' => $tasks]);

    }
    public function query(){

        $task = Task::all(); // select * from tasks;

        $task = Task::select()->get(); // select * from tasks;

        $task = Task::select()->orderby('title')->get(); // select * from tasks order by title;

        $task = Task::select()->orderby('id', 'desc')->get(); // select * from tasks order by id desc;
       
        $task = Task::select('id', 'title')->orderby('id', 'desc')->get(); // select id, title from tasks order by id desc;
       
        $task = Task::select()->where('id','>', 3)->get();
        // select * from tasks where id > 3;

        $task = Task::select()->where('title','like', 'a%')->get();

        $task = Task::where('title','like', 'a%')->get();
        // select * from tasks where title like "a%";

        $task = Task::select()->where('id', 3)->get();
        // select * from tasks where id = 3; return []


        $task = Task::select()->where('id', 3)->first();
        // select * from tasks where id = 3; return {}

        $task = Task::find(3);
        //return {}
        
        $task = Task::select()
            ->where('user_id', 1)
            ->where('completed', 1)
            ->get();

        // Select * FROM tasks WHERE user_id = 1 AND completed = 1;

        $task = Task::select()
        ->where('user_id', 1)
        ->orwhere('completed', 1)
        ->orderBy('title')
        ->get();

        // Select * FROM tasks WHERE user_id = 1 OR completed = 1;

        $task = Task::select()
        ->join('users', 'tasks.user_id', 'users.id')
        ->get();
    
        //SELECT * FROM tasks INNER JOIN users ON user.id = task.user_id;


        $task = Task::select()
        ->rightJoin('users', 'tasks.user_id', '=','users.id')
        ->get();
        // SELECT * FROM tasks inner OUTER JOIN users ON users.id = tasks.user_id;


        $task = Task::count();
        //select count(*) from task;
        
        $task = Task::where('completed', 0)->count();
        //select count(*) from task WHERE completed = 0;

        $task = Task::select(DB::raw('count(*) as count_tasks, user_id'))
        ->groupby('user_id')
        ->get();

        //SELECT count(*) as count_tasks, user_id FROM laravel_todo.tasks GROUP BY user_id;

        return $task;
    }

    public function pdf(Task $task){

        $qrCode = QrCode::size(200)->generate(route('task.show', $task->id));

        $pdf = new Dompdf();
        $pdf->setPaper('letter', 'portrait');
        $pdf->loadHtml(view('task.show-pdf', ["task" => $task, "qrCode"=> $qrCode]));
        $pdf->render();
        return $pdf->stream('task_'.$task->id.'.pdf');

        //return view('task.show-pdf', compact('task'));
    }
}
