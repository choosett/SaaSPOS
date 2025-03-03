<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Business extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'businesses';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'business_id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'business_name',
        'start_date',
        'currency',
        'logo',
        'website',
        'business_contact',
        'alternate_contact',
        'district',
        'business_address',
        'zip_code',
        'bin_number',
        'dbid_number',
        'financial_year',
        'stock_method',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'business_id', 'business_id');
    }

    /**
     * Boot method to trigger actions on model events.
     */
    protected static function boot()
    {
        parent::boot();

        // ✅ যখন নতুন Business তৈরি হবে, তখন স্বয়ংক্রিয়ভাবে রোল ও পারমিশন সেট হবে
        static::created(function ($business) {
            self::assignDefaultRolesAndPermissions($business->business_id);
        });
    }

    /**
     * ✅ নতুন ব্যবসার জন্য `Admin` এবং `Cashier` রোল তৈরি এবং পারমিশন সেট করা
     */
    private static function assignDefaultRolesAndPermissions($businessId)
    {
        // ✅ Define Permissions
        $permissions = [
            'dashboard.view',
            'roles.view', 'roles.create', 'roles.edit', 'roles.delete',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'admin.access'
        ];

        // ✅ Ensure All Permissions Exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ✅ Create Business-Specific Roles
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'business_id' => $businessId,
            'guard_name' => 'web'
        ]);

        $cashier = Role::firstOrCreate([
            'name' => 'cashier',
            'business_id' => $businessId,
            'guard_name' => 'web'
        ]);

        // ✅ Assign All Permissions to Admin
        $admin->syncPermissions($permissions);

        // ✅ Assign Limited Permissions to Cashier
        $cashier->syncPermissions(['users.view']);
    }
}
