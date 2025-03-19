<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathaoApiCredential extends Model
{
    use HasFactory;

    protected $table = 'pathao_api_credentials'; // ✅ Ensure correct table name
    protected $primaryKey = 'courier_id'; // ✅ Set 'courier_id' as primary key
    public $incrementing = false; // ✅ Disable auto-incrementing (since it's a string)
    protected $keyType = 'string'; // ✅ Ensure the primary key is treated as a string

    protected $fillable = [
        'courier_id', // ✅ Ensure 'courier_id' is fillable
        'business_id',
        'courier_name',
        'credentials',
    ];

    protected $casts = [
        'credentials' => 'array', // ✅ Automatically cast JSON data to an array
    ];

    /**
     * ✅ Automatically generate `courier_id` before creating a new record.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // ✅ Generate a unique `courier_id` in format: P-1001, P-1002
            $lastRecord = static::where('courier_id', 'LIKE', 'P-%')
                ->orderBy('courier_id', 'desc')
                ->first();

            $newId = $lastRecord ? 'P-' . (intval(substr($lastRecord->courier_id, 2)) + 1) : 'P-1001';
            $model->courier_id = $newId; // ✅ Assign generated `courier_id`
        });
    }

    /**
     * ✅ Relationship with businesses.
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
