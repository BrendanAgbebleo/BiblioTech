<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Loan;

class BookCopy extends Model
{
    protected $fillable = [];
    public function book() { return $this->belongsTo(Book::class); }
    public function loans() { return $this->hasMany(Loan::class); }

}
