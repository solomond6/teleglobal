<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    use HasFactory;

    //task collection
    protected $fillable = ['name','description','status','user_id'];

    //declare the relationship
    public function users(){
        return $this->belongsTo(User::class, 'user_id'); 
    }

}
