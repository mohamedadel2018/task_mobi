<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class task_comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function commenter()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    
    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d H:i');
    }

}
