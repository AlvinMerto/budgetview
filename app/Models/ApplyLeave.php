<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class ApplyLeave extends Model
{
    use HasFactory;

    protected $table = "apply_leaves";
    protected $fillable = [
        "userid","dates","typeofleave","reason","status","created_at","updated_at"
    ];

    function thename() {
        return $this->hasOne(User::class,"id","userid");
    }

}
