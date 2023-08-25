<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subkriteriaM extends Model
{
    use HasFactory;
    protected $table = "subkriteria";
    protected $primaryKey = "idsubkriteria";
    protected $guarded = [];
}
