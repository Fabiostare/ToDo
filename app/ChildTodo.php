<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildTodo extends Model
{
    protected $fillable = ['parent_id', 'name', 'completed'];

    public function todos() {
        return $this->belongsTo(Todo::class);
    }
}
