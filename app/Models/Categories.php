<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
class Categories extends Model
{
    use HasUlids;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'type',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'category_id');
    }
}
