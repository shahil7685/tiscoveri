<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialHubCategory extends Model
{
    use HasFactory;

    protected $table = 'social_hub_category';

    protected $fillable = [
        'name', 'image'
    ];
}
