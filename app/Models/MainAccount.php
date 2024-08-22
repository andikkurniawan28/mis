<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class MainAccount extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($main_account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Main Account '{$main_account->name}' was created.",
            ]);
        });

        static::updated(function ($main_account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Main Account '{$main_account->name}' was updated.",
            ]);
        });

        static::deleted(function ($main_account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Main Account '{$main_account->name}' was deleted.",
            ]);
        });
    }

    public function account_group(){
        return $this->belongsTo(AccountGroup::class);
    }
}
