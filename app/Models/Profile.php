<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        $lastName = ucfirst(strtolower($this->last_name));
        $firstName = ucfirst(strtolower($this->first_name));

        $fullName = "{$lastName}, {$firstName}";
        if (! empty($this->middle_name)) {
            $middleName = ucfirst(strtolower($this->middle_name));

            $fullName .= " {$middleName[0]}.";
        }

        // $fullName = ucfirst(strtolower($fullName));

        return $fullName;
    }

    public function borrowers()
    {
        return $this->hasMany(Borrower::class);
    }
}
