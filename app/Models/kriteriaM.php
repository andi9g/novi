<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kriteriaM extends Model
{
    use HasFactory;
    protected $table = "kriteria";
    protected $primaryKey = "idkriteria";
    protected $guarded = [];
}
