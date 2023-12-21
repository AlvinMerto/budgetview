<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inputwindow extends Model
{
    use HasFactory;
    protected $primaryKey = "activityid";
    protected $table      = "inputwindows";
    protected $fillable   = [
        "activitygrpid","activitytitle","initialcost","actualcost","dateofactivity",
        "daterelease","daterecvbyoc","datereleasedbyoc","daterecvbyproc","date_po","status",
        "division","created_at","updated_at"
    ];

}
