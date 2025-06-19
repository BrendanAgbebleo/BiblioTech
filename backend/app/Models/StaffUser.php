<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StaffLog;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class StaffUser extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable =[
        'uid',
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
   public function logs() { return $this->hasMany(StaffLog::class); } 
}
