<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'info',
        'is_link'
    ];

    public function profile():BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
