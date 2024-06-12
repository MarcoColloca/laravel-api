<?php

namespace App\Models;

use App\Http\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, Sluggable;


    public function type()
    {
        // Non serve importare Type, in quanto se non importato viene cercato nello stesso namespace dove si trova, e in questo caso Project ha lo stesso namepasce di Project
        return $this->belongsTo(Type::class);
    }


    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    protected $fillable = ['name', 'slug', 'link', 'description', 'date_of_creation', 'is_public', 'contributors', 'contributors_link', 'type_id'];

}
