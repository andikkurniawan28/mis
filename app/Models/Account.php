<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class Account extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Account '{$account->name}' was created.",
            ]);
        });

        static::updated(function ($account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Account '{$account->name}' was updated.",
            ]);
        });

        static::deleted(function ($account) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Account '{$account->name}' was deleted.",
            ]);
        });
    }

    public function sub_account(){
        return $this->belongsTo(SubAccount::class);
    }

    // public function normal_balance(){
    //     return $this->belongsTo(NormalBalance::class);
    // }

    public function cash_flow_category(){
        return $this->belongsTo(CashFlowCategory::class);
    }

    public function ledger(){
        return $this->hasMany(Ledger::class);
    }
}
