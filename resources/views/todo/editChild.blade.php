@extends('layouts.app')
@section('content')
    <div class="w-100 h-100 d-flex justify-content-center align-items-center">
        <div class="text-center" style="width: 40%">
            <h1 class="display-2 text-white">{{ $todo->name }}</h1>
            <div class="text-left mb-2"><a class="nav-link text-white" href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="20"
                         height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <polyline points="15 6 9 12 15 18"/>
                    </svg>
                    Назад</a></div>
            <form action="{{ route('childTodo.update', $todo->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="input-group mb-3 w-100">
                    <input type="text" class="form-control form-control-lg" name="name" value="{{ $todo->name }}"
                           aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="button-addon2">Сохранить</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection

