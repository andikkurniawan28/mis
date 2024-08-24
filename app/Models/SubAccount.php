<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class SubAccount extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($sub_account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Sub Account '{$sub_account->name}' was created.",
            ]);
        });

        static::updated(function ($sub_account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Sub Account '{$sub_account->name}' was updated.",
            ]);
        });

        static::deleted(function ($sub_account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Sub Account '{$sub_account->name}' was deleted.",
            ]);
        });
    }

    public function main_account(){
        return $this->belongsTo(MainAccount::class);
    }

    public function account(){
        return $this->hasMany(Account::class);
    }
}
