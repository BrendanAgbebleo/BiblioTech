<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Category extends Model
{
    protected $fillable=[];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_category');
    }
}
