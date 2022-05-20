<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualApplication extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'zamsha', 'row', 'edging', 'name', 'phone', 'comment', 'price'];
}
