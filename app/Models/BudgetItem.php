<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }

    protected static function booted()
    {
        static::saving(function ($item) {
            $item->sub_total = $item->amount * $item->qty;
        });

        static::saved(function ($item) {
            $item->budget->recalculateTotals();
        });

        static::deleted(function ($item) {
            $item->budget->recalculateTotals();
        });
    }

    protected $fillable = [
        'budget_id',
        'description',
        'type',
        'amount',
        'qty',
        'sub_total',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function spendings()
    {
        return $this->hasMany(Spending::class);
    }
}
