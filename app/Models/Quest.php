<?php

namespace App\Models;
use App\Models\Questlog;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = ['title', 'description', 'type', 'user_id'];

    public function log(){
        return $this->hasMany(Questlog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
