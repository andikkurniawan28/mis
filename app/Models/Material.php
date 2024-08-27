<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class Material extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($material) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Material '{$material->name}' was created.",
            ]);
        });

        static::updated(function ($material) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Material '{$material->name}' was updated.",
            ]);
        });

        static::deleted(function ($material) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "Material '{$material->name}' was deleted.",
            ]);
        });
    }

    public function material_sub_category(){
        return $this->belongsTo(MaterialSubCategory::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
