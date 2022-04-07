<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class SteamReview extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'steam_appid', 'name', 'playtime_forever', 'review', 'recomended'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
