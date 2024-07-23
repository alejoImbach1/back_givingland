<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Moderator extends Model
{
    use HasFactory;
    public function posts():BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function reportedPosts():BelongsToMany
    {
        return $this->belongsToMany(ReportedPost::class);
    }
}
