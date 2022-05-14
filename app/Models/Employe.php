<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function license(){
        return $this->hasMany(License::class,'nik','nik');
    }
}
