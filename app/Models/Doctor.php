<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'qualifications',
        'specialty',
        'languages',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
