<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sekolahkriteriaM extends Model
{
    use HasFactory;
    protected $table = "sekolahkriteria";
    protected $primaryKey = "idsekolahkriteria";
    protected $guarded = [];
}
