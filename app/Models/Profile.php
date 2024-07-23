<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_avatar'
        // 'user_id'
    ];

    public function getImageUrl(): string
    {
        return ($this->google_avatar) ? $this->google_avatar: asset('storage/users_profile_images/' . $this->image->url);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function contactInformation(): HasMany
    {
        return $this->hasMany(ContactInformation::class);
    }

    public function socialMedia(): BelongsToMany
    {
        return $this->belongsToMany(SocialMedia::class)->withPivot('username');
    }
}
