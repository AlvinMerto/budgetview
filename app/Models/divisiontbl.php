<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class divisiontbl extends Model
{
    use HasFactory; 
    protected $table        = "divisiontbls";
    protected $primaryKey   = "divisionid";
    protected $fillable     = [
        "divaccr","divfullname","created_at","updated_at"
    ];

}
