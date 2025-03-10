<?php
namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = ['name', 'guard_name', 'business_id'];

    // 🔒 Ensure permissions are assigned under the current business
    public static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            if (auth()->check()) {
                $permission->business_id = auth()->user()->business_id;
            }
        });
    }
}
