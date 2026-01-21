<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Méthodes de vérification des rôles
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relation avec Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper pour vérifier si admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}