<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Define fields of table that can be stored
    protected $fillable = ['title', 'content', 'user_id', 'image'];

    // List of many post to a user
    public function user() { 
        return $this->belongsTo(User::class); 
    }

    // A post has many commets
    public function comments() { 
        return $this->hasMany(Comment::class); 
    }
}
