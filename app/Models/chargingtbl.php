<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chargingtbl extends Model
{
    use HasFactory;

    protected $table        = "chargingtbls";
    protected $primaryKey   = "chargingid";
    protected $fillable     = [
        "chargingname","divisionid","created_at","updated_at"
    ];

    
    public function activity_designs($divid) {
        
    }
}
