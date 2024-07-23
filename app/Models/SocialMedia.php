<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SocialMedia extends Model
{
    use HasFactory;

    public function profiles():BelongsToMany
    {
        return $this->belongsToMany(Profile::class)->withPivot('username');
    }

    public function image():MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
