<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedxApiCredential extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'courier_id';
    protected $keyType = 'string';

    protected $fillable = [
        'courier_id',
        'business_id',
        'courier_name',
        'credentials',
    ];

    protected $casts = [
        'credentials' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    // ✅ Auto-generate courier_id in format R-1001, R-1002, etc.
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestCourier = static::latest('courier_id')->first();
            $nextId = $latestCourier ? ((int) substr($latestCourier->courier_id, 2)) + 1 : 1001;
            $model->courier_id = 'R-' . $nextId;
        });
    }
}
