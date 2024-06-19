<?php

namespace App\Models;

use App\Http\Traits\Sluggable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Project extends Model
{
    use HasFactory, Sluggable, SoftDeletes;


    public function type()
    {
        // Non serve importare Type, in quanto se non importato viene cercato nello stesso namespace dove si trova, e in questo caso Project ha lo stesso namepasce di Project
        return $this->belongsTo(Type::class);
    }


    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }


    protected function coverFullPath():Attribute
    {
        return new Attribute(
            get: fn () => $this->cover_image ? asset('http://127.0.0.1:8000/storage/' . $this->cover_image) : null
        );

    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d-m-Y');
    }


    protected $fillable = ['name', 'slug', 'link', 'description', 'date_of_creation', 'is_public', 'contributors', 'contributors_link', 'type_id', 'cover_image'];

    protected $appends = ['cover_full_path'];
}
