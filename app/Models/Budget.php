<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Budget extends Model
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
        'month_periode',
        'year',
        'description',
        'total_budget',
        'total_already_spended',
    ];

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recalculateTotals()
    {
        $this->total_budget = $this->budgetItems()->sum('sub_total');
        $this->save();
    }

    public function recalculateSpent()
    {
        // Calculate total spent from all budget items linked to this budget
        // We need to sum up the spendings of all budgetItems
        // A Budget hasMany BudgetItems, and BudgetItems hasMany Spendings
        
        $totalSpent = $this->budgetItems()->withSum('spendings', 'amount')->get()->sum('spendings_sum_amount');
        
        $this->total_already_spended = $totalSpent;
        $this->save();
    }
}
