<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WikiChallenges extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'start', 'end'];

    function wikiPaths() {
        return $this->hasMany(WikiPath::class);
    }
}
