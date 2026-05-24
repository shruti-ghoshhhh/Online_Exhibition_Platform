<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'banner_image', 'category', 'status', 'is_featured', 'start_date', 'end_date', 'views'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
