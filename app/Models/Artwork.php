<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    protected $fillable = [
        'exhibition_id', 'user_id', 'title', 'description', 'image_path', 'artist_name', 'views', 'display_order'
    ];
    
    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
