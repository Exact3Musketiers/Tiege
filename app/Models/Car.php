<?php

namespace App\Models;

use App\Traits\SharedResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    use SharedResource;

    protected $baseRoute = 'driving';
    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'year',
        'image_path',
        'total_distance',
        'avg_usage',
    ];

    public function get_image() {
        return is_null($this->image_path) ? asset('images/placeholder-square.jpeg') : Storage::url($this->image_path);
    }
}
