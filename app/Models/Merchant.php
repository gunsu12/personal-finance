<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \Illuminate\Database\Eloquent\Concerns\HasUuids, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = ['user_id', 'name', 'category'];

    public function newUniqueId(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
