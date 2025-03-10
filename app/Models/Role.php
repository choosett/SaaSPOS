<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Role extends SpatieRole implements RoleContract
{
    protected $fillable = ['name', 'guard_name', 'business_id'];

    /**
     * Override Spatie’s role lookup to ensure business_id is included.
     */
    public static function findByName(string $name, ?string $guardName = null): SpatieRole
    {
        $businessId = auth()->check() ? auth()->user()->business_id : null;

        return static::where('name', $name)
            ->where('guard_name', $guardName ?? 'web')
            ->where('business_id', $businessId)
            ->firstOrFail();
    }

    /**
     * Override Spatie's `findOrCreate()` to ensure roles are unique per business.
     */
    public static function findOrCreate(string $name, ?string $guardName = null): SpatieRole
    {
        $businessId = auth()->check() ? auth()->user()->business_id : null;

        $role = static::where('name', $name)
            ->where('guard_name', $guardName ?? 'web')
            ->where('business_id', $businessId)
            ->first();

        if (!$role) {
            return static::create([
                'name' => $name,
                'guard_name' => $guardName ?? 'web',
                'business_id' => $businessId,
            ]);
        }

        return $role;
    }
}
