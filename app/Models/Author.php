<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $appends = ['full_name'];

    public function books()
    {

        return $this->hasMany(Book::class);
    }

    public function getFullNameAttribute()
    {
        $fullName = "{$this->last_name}, {$this->first_name}";
        if (! empty($this->middle_name)) {
            $fullName .= " {$this->middle_name[0]}.";
        }

        return $fullName;
    }
}
