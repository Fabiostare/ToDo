<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $todos = Todo::where('user_id', $request->user()->id)->latest()->get();
            return view('welcome')->with('todos', $todos);
        } else {
            return redirect('home');
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $validatedData = $request->validate([
                'title' => 'required|max:255'
            ]);

            $todo = Todo::create([
                'user_id' => $user->id,
                'name' => $request->title,
                'completed' => 0,
            ]);

            return redirect('/');
        } else {
            return redirect('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Todo $todo)
    {
        $user = $request->user();

        if ($user && $user->id == $todo->user_id) {
            return view('todo.edit')->with('todo', $todo);
        } else {
            return redirect('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $user = $request->user();

        if ($user && $user->id == $todo->user_id) {
            $todo->update($request->all());
            return redirect('/');
        } else {
            return redirect('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\Todo $todo
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Todo $todo)
    {
        $user = $request->user();

        if ($user && $user->id == $todo->user_id) {
            $todo->delete();
            return redirect('/');
        } else {
            return redirect('home');
        }
    }

    /**
     * uploadFile an add a file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'TodoId' => 'required|max:255'
        ]);

        if ($request->hasFile('file')) {
            $todo = Todo::find($request->TodoId);

            $todo->addMedia($request->file('file'))->toMediaCollection('docs');

            return redirect('/childes/' . $request->TodoId);
        }

        return redirect('home');
    }

    /**
     * downloadFile an download a file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $validatedData = $request->validate([
            'fileId' => 'required|max:255',
            'parentId' => 'required|max:255'
        ]);

        $todo = Todo::find($request->parentId);
        $file = $todo->getMedia('docs')->find($request->fileId);

        return response()->download($file->getPath(), $file->file_name);

    }
}
