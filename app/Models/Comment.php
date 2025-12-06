<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Fields can be stored
    protected $fillable = [
        'content', 'post_id', 'user_id',
        'guest_name', 'guest_email'
    ];

    // Relationship with post
    public function post() { 
        return $this->belongsTo(Post::class); 
    }
    
    // Relationship with user
    public function user() { 
        return $this->belongsTo(User::class); 
    }


}
