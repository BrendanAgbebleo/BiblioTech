<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;


class Customer extends Model
{
    protected $fillable =[];
    public function loans() { return $this->hasMany(Loan::class); }

}
