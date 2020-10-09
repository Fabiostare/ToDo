@extends('layouts.app')
@section('content')
    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
        <div class="text-center" style="width: 40%">
            <h1 class="display-2 text-white">{{ $parentTodo->name }}</h1>
            <div class="text-left mb-2"><a class="nav-link text-white" href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="20"
                         height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <polyline points="15 6 9 12 15 18"/>
                    </svg>
                    Назад</a></div>
            <form action="{{ route('childTodo.store') }}" method="POST">
                @csrf
                <div class="input-group mb-3 w-100">
                    <input type="text" class="form-control form-control-lg" name="title"
                           aria-label="Recipient's username" aria-describedby="button-addon2">
                    <input type="text" name="parentId" value="{{ $parentTodo->id }}" hidden>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="button-addon2">Добавить подзадачу</button>
                    </div>
                </div>
            </form>

            <form action="{{ route('todo.uploadFile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3 w-100">
                    <input type="file" class="form-control form-control-lg" name="file"
                           aria-label="Recipient's username" aria-describedby="button-addon2">
                    <input type="text" name="TodoId" value="{{ $parentTodo->id }}" hidden>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="button-addon2">Добавить файл</button>
                    </div>
                </div>
            </form>

            <div>
                @foreach($files as $file)
                    <form action="{{ route('todo.downloadFile') }}" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="fileId" value="{{ $file->id }}" hidden>
                            <input type="text" name="parentId" value="{{ $parentTodo->id }}" hidden>
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit" id="button-addon2">{{ $file->name }}</button>
                            </div>

                        </div>
                    </form>
                @endforeach
            </div>

            <h2 class="text-white pt-2">Подзадачи:</h2>
            <div class="bg-white w-100">
                @foreach($childTodos as $todo)
                    <div class="w-100 d-flex align-items-center justify-content-between">
                        <div class="p-4">
                            @if($todo->completed)
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                                     width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l5 5l10 -10"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-dots-circle-horizontal" width="36" height="36"
                                     viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="9"/>
                                    <line x1="8" y1="12" x2="8" y2="12.01"/>
                                    <line x1="12" y1="12" x2="12" y2="12.01"/>
                                    <line x1="16" y1="12" x2="16" y2="12.01"/>
                                </svg>
                            @endif
                            {{ $todo->name }}
                        </div>
                        <div class="mr-4 d-flex align-items-center">
                            @if($todo->completed)
                                <form action="{{ route('childTodo.update', $todo->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <input type="text" name="completed" value="0" hidden>
                                    <button class="btn btn-warning">не выполнено</button>
                                </form>
                            @else
                                <form action="{{ route('childTodo.update', $todo->id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <input type="text" name="completed" value="1" hidden>
                                    <button class="btn btn-success">Выполнено</button>
                                </form>
                            @endif
                            <a class="in-lane-block" href="{{ route('childTodo.edit', $todo->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit ml-4"
                                     width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"/>
                                    <line x1="16" y1="5" x2="19" y2="8"/>
                                </svg>
                            </a>
                            <form action="{{ route('childTodo.destroy', $todo->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="border-0 bg-transparent ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash "
                                         width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <line x1="4" y1="7" x2="20" y2="7"/>
                                        <line x1="10" y1="11" x2="10" y2="17"/>
                                        <line x1="14" y1="11" x2="14" y2="17"/>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
