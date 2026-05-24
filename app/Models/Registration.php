<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = ['exhibition_id', 'user_id', 'registered_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
}
