<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function shift(){
        return $this->belongsTo(Shift::class);
    }

    protected static function booted()
    {
        static::created(function ($attendance) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Attendance '{$attendance->employee->name}' was created.",
            ]);
        });

        static::updated(function ($attendance) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Attendance '{$attendance->employee->name}' was updated.",
            ]);
        });

        static::deleted(function ($attendance) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Attendance '{$attendance->employee->name}' was deleted.",
            ]);
        });
    }
}
