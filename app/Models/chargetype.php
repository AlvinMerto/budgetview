<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chargetype extends Model
{
    use HasFactory;

    protected $table      = "chargetypes";
    protected $primaryKey = "chargetypeid";
    protected $fillable   = [
        "chargename","created_at","updated_at"
    ];
}
