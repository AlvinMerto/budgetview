<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class budgetview extends Model
{
    use HasFactory;

    protected $table        = "budgetviews";
    protected $primaryKey   = "budgetviewid";
    protected $fillable     = [
        "divid","planned","actual","year","isactive","created_at","updated_at"
    ];
}
