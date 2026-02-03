<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Spending extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'budget_item_id',
        'spending_date',
        'spending_time',
        'amount',
        'merchant',
        'merchant_id',
        'transaction_methods',
        'notes',
    ];

    protected static function booted()
    {
        static::creating(function ($spending) {
            $date = $spending->spending_date ? \Carbon\Carbon::parse($spending->spending_date) : now();
            $dateStr = $date->format('Ymd');

            if (empty($spending->spending_time)) {
                $spending->spending_time = now();
            }
            
            // Generate Code: SPN/YYYYMMDD/00001
            $count = static::whereDate('spending_date', $date)->count() + 1;
            $spending->code = 'SPN/' . $dateStr . '/' . str_pad($count, 5, '0', STR_PAD_LEFT);
        });

        static::saved(function ($spending) {
            if ($spending->budgetItem) {
                // We need to load the relationship if not already loaded, or use accessors
                // $spending->budgetItem is available via relationship
                $spending->budgetItem->budget->recalculateSpent();
            }
        });

        static::deleted(function ($spending) {
             if ($spending->budgetItem) {
                $spending->budgetItem->budget->recalculateSpent();
            }
        });
    }

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }

    public function budgetItem()
    {
        return $this->belongsTo(BudgetItem::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
