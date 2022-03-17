<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamReview extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'steam_appid', 'name', 'playtime_forever', 'review'];
}
