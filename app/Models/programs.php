<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\chargingtbl;

class programs extends Model
{
    use HasFactory;

    protected $table = "programs";
    protected $fillable = [
        "theprograms","divisionid","status","created_at","updated_at"
    ];

    public function get_ads() {
        return $this->hasMany(chargingtbl::class,"chargingid","divisionid");
    }
}
