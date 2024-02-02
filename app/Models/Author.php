<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'age',
        'country',
        'genre'
    ];

    //format created at usinf attribute
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->toDateTimeString();
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
