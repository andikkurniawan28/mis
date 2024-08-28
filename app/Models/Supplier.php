<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function business(){
        return $this->belongsTo(Business::class);
    }

    protected static function booted()
    {
        static::created(function ($supplier) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Supplier '{$supplier->name}' was created.",
            ]);
        });

        static::updated(function ($supplier) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Supplier '{$supplier->name}' was updated.",
            ]);
        });

        static::deleted(function ($supplier) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Supplier '{$supplier->name}' was deleted.",
            ]);
        });
    }
}
