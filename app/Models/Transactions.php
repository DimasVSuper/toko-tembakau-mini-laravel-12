<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Transactions extends Model
{
    use HasFactory, HasUlids;
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'type',
        'date',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
