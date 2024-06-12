<?php

namespace App\Models;

use App\Http\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory, Sluggable;

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
    
    
    
    protected $fillable = ['name', 'slug'];

}
