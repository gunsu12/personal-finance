<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'qty',
        'unit',
        'price',
        'sub_total',
        'expected_return',
    ];

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AssetChangeLog::class);
    }

    protected static function booted()
    {
        static::creating(function ($asset) {
            $asset->sub_total = $asset->qty * $asset->price;
        });

        static::updating(function ($asset) {
            $asset->sub_total = $asset->qty * $asset->price;
            
            // Log price change if price changed
            if ($asset->isDirty('price')) {
                // We access the original price via $asset->getOriginal('price')
                // But we want to log the NEW price as part of history?
                // Or log the OLD price?
                // Request says "asset_change_log - price".
                // Usually change logs track history. So maybe we log the NEW price on update.
                // Or maybe we should log every time it changes.
                
                // Let's create a log entry for the new price state
                // Note: Triggered AFTER update might be safer for ID existence, but here is fine.
            }
        });
        
        static::updated(function ($asset) {
             if ($asset->wasChanged('price')) {
                $asset->logs()->create([
                    'price' => $asset->price
                ]);
            }
        });
        
        static::created(function ($asset) {
            // Log initial price
            $asset->logs()->create([
                'price' => $asset->price
            ]);
        });
    }
}
