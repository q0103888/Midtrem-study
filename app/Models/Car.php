<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    //protected $fillable = [];
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getImageAttribute($value) {
        return '/storage/'.$value;
        // return해주면 Accessor에 접근하여 
    }
}
