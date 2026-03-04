<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'stock',
        'category_id'
    ];

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
