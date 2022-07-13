<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiPath extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'start', 'end', 'click_count'];
}