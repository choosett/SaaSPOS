<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathaoLocation extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'city_name', 'zone_id', 'zone_name', 'area_id', 'area_name'];
}
