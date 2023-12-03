<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chargingto extends Model
{
    use HasFactory;

    protected $table      = "chargingtos";
    protected $primaryKey = "chargeid";
    protected $fillable   = [
        "activitygrpid","actualcost","chargewhat","chargeto","chargetype","created_at","updated_at"
    ];

}
