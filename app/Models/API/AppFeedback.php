<?php

namespace App\Models\API;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFeedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'rating',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
