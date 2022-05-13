<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewItem extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'city', 'auto', 'color', 'message', 'images', 'item_id'];
}
