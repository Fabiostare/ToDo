<?php

namespace App\Http\Controllers;

use App\ChildTodo;
use App\Todo;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class ChildTodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $parentId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $parentId)
    {
        $user = $request->user();

        $parentTodo = Todo::find($parentId);

        if ($parentTodo->user_id == $user->id) {
            $childTodos = ChildTodo::where('parent_id', $parentId)->latest()->get();
            $files = $parentTodo->getMedia('docs');
            return view('todo.childes', ['parentTodo' => $parentTodo, 'childTodos' => $childTodos, 'files' => $files]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $parentTodo
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'parentId' => 'required|max:255'
        ]);

        $user = $request->user();
        $parentId = $request->parentId;
        $parentTodo = Todo::find($parentId);

        if ($parentTodo->user_id == $user->id) {
            $todo = ChildTodo::create([
                'user_id' => $user->id,
                'name' => $request->title,
                'parent_id' => $parentId,
                'completed' => 0,
            ]);

            return redirect('/childes/' . $request->parentId);
        } else {
            return redirect('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
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
     * @param \App\ChildTodo $childTodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ChildTodo $childTodo)
    {
        $user = $request->user();
        $parentId = $childTodo->parent_id;
        $parentTodo = Todo::find($parentId);

        if ($parentTodo->user_id == $user->id) {
            return view('todo.editChild')->with('todo', $childTodo);
        } else {
            return redirect('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChildTodo  $childTodo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChildTodo $childTodo)
    {
        $user = $request->user();
        $parentId = $childTodo->parent_id;
        $parentTodo = Todo::find($parentId);

        if ($parentTodo->user_id == $user->id) {
            $childTodo->update($request->all());
            return redirect('/childes/' . $childTodo->parent_id);
        } else {
            return redirect('home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\ChildTodo $childTodo
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, ChildTodo $childTodo)
    {
        $user = $request->user();
        $parentId = $childTodo->parent_id;
        $parentTodo = Todo::find($parentId);

        if ($parentTodo->user_id == $user->id) {
            $childTodo->delete();
            return redirect('/childes/' . $childTodo->parent_id);
        } else {
            return redirect('home');
        }
    }
}
