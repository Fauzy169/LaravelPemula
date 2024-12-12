<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('search')) {
            $data = Todo::where('task','like','%'.request('search').'%')->paginate(3)->withQueryString();
        } else {
            $data = Todo::orderBy('task','asc')->paginate(3);
        }
        return view('todo.app', ['data' => $data]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|min:3|max:30'
        ],[
            'task.required' => 'Perlu Untuk Diisikan',
            'task.min' => 'minimal mengisi 3 Karakter',
            'task.max' => 'maksimal karakter yang diisikan itu 30 Karakter'
        ]);

        $data = [
            'task' => $request->input('task')
        ];

        Todo::create($data);
        return redirect()->route('todo')->with('success', 'Task Baru Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'task' => 'required|min:3|max:30'
        ],[
            'task.required' => 'Perlu Untuk Diisikan',
            'task.min' => 'minimal mengisi 3 Karakter',
            'task.max' => 'maksimal karakter yang diisikan itu 30 Karakter'
        ]);

        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done')
        ];

        Todo::where('id',$id)->update($data);
        return redirect()->route('todo')->with('success', 'Task Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::where('id',$id)->delete();
        return redirect()->route('todo')->with('success','Data Berhasil Dihapuskan');
    }
}
