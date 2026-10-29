<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'user_id', 'launch_id', 'category_id', 'name', 'description', 'value',
        'installments', 'installment_number', 'installment_group', 'due_date',
    ];

    protected function casts(): array
    {
        return ['value' => 'decimal:2', 'due_date' => 'date'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function launch() { return $this->belongsTo(Launch::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
