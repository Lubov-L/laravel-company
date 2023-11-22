<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    public $timestamps = false;

    protected $guarded = false;

    protected $fillable = ['name', 'description', 'logo'];
}
