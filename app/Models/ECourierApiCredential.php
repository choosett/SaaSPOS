<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ECourierApiCredential extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'courier_id';
    protected $keyType = 'string';
    protected $table = 'ecourier_api_credentials'; // ✅ Ensure correct table name

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

    /**
     * ✅ Auto-generate `courier_id` for new records
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // ✅ Fetch latest courier_id from database
            $latestCourier = static::where('courier_id', 'LIKE', 'E-%')
                ->orderBy('courier_id', 'desc')
                ->first();

            // ✅ Generate next ID (E-1001, E-1002, ...)
            $nextId = $latestCourier ? ((int) substr($latestCourier->courier_id, 2)) + 1 : 1001;
            $model->courier_id = 'E-' . $nextId;
        });
    }
}
