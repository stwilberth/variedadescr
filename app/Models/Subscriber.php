<?php

namespace anuncielo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['email'];

    protected $keyType = 'string'; // UUID es un string
    public $incrementing = false; // Desactiva incremento automático

    protected static function booted()
    {
        static::creating(function ($subscriber) {
            $subscriber->id = Str::uuid()->toString();
        });
    }
}
