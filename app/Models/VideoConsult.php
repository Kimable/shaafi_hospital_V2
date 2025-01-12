<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConsult extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'time',
        'medical_issue',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
