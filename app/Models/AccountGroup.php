<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AccountGroup extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($account_group) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Account Group '{$account_group->name}' was created.",
            ]);
        });

        static::updated(function ($account_group) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Account Group '{$account_group->name}' was updated.",
            ]);
        });

        static::deleted(function ($account_group) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Account Group '{$account_group->name}' was deleted.",
            ]);
        });
    }

    public function financial_statement(){
        return $this->belongsTo(FinancialStatement::class);
    }

    public function normal_balance(){
        return $this->belongsTo(NormalBalance::class);
    }

    public function main_account(){
        return $this->hasMany(MainAccount::class);
    }
}
