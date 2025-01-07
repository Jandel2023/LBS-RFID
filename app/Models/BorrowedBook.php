<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowedBook extends Model
{
    //
    use SoftDeletes;

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
