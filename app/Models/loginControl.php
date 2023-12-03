<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loginControl extends Model
{
    use HasFactory;

    protected $primaryKey = "profileid";
    protected $table      = "login_controls";
    protected $fillable   = [
        "userid","divisionid","accounttype","created_at","updated_at"
    ];

}
