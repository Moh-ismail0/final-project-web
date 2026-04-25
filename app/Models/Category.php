<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
        protected $fillable = ['name'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function comments()
{
    return $this->morphMany(Comment::class, 'commentable'); //commentable =>(commentable_id و commentable_type)اسم العلاقة الي هضيفيلي بشكل تلقائي عمودين 
}
}
