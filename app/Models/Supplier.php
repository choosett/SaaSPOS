<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Import User Model

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id', 'contact_id', 'supplier_name', 'phone',
        'email', 'assigned_to', 'opening_balance', 'advance_balance', 'address'
    ];

    /**
     * A Supplier belongs to a User (Assigned User).
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }
}

