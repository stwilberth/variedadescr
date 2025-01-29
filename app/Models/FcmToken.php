<?php

namespace anuncielo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    use HasFactory;

    protected $table = 'fcm_tokens';

    protected $fillable = ['user_id', 'token', 'topic'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
