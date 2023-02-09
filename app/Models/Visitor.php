<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    // protected $hidden = ['location'];
    
    public function getLocationAttribute($location){
        return json_decode($location);
    }
}
