<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class task extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function members()
    {
        return $this->belongsToMany(User::class, 'task_members', 'task_id', 'user_id');
    }


    public function files()
    {
        return $this->hasMany(task_files::class,'task_id');
    }


    
    public function comments()
    {
        return $this->hasMany(task_comment::class,'task_id');
    }

    
    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value);
        return $date->format('Y-m-d H:i');
    }
}
