<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AssetChangeLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['asset_id', 'price'];

    public function newUniqueId(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
