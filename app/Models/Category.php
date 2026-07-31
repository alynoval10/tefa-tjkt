<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function kas()
{
    return $this->hasMany(Kas::class);
}
}