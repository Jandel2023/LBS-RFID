<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrower extends Model
{
    //
    use HasFactory, SoftDeletes;

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function borrowed_books()
    {
        return $this->hasMany(BorrowedBook::class);
    }
}
