<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StaffLog;

class StaffUser extends Model
{
    protected $fillable =[];
   public function logs() { return $this->hasMany(StaffLog::class); } 
}
