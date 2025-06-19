<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BookCopy;
use App\Models\Category;


class Book extends Model
{
    // Allow mass assignment on these fields
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'price',
        'description',
        'cover_img',
        'release_date',
        'added_date',
    ];

    /**
     * Get all copies of this book.
     */
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }

    /**
     * The categories that this book belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }
}