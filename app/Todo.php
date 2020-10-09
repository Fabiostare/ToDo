<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Todo extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = ['user_id', 'name', 'completed'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function childTodo() {
        return $this->hasMany(ChildTodo::class);
    }
}
