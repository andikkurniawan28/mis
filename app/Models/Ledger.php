<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function journal(){
        return $this->belongsTo(Journal::class);
    }
}
