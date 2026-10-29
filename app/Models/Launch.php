<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Launch extends Model
{
    protected $fillable = ['user_id', 'name', 'month', 'year'];

    public function user() { return $this->belongsTo(User::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
}
