<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CashFlow extends Model
{
    use HasFactory, HasUuids;

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }

    protected $fillable = [
        'user_id',
        'type',
        'group',
        'amount',
        'transaction_notes',
        'transaction_refference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
