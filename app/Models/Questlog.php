<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quest;
class Questlog extends Model
{
    protected $fillable = ['quest_id', 'user_id'];
    public function quest(){
        return $this->belongsTo(Quest::class);
    }
}
