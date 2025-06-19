<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\BookCopy;

class Loan extends Model
{
    protected $fillable = [];

    public function customer() { return $this->belongsTo(Customer::class); }
    public function copy() { return $this->belongsTo(BookCopy::class, 'book_copy_id'); }
}
