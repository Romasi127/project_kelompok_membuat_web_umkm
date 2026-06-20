<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'category', 'description', 'price', 'image', 'cooking_options'])]
class Menu extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'cooking_options' => 'array',
        ];
    }
}
