<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
