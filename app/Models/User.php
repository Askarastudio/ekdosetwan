<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function canBorrow()
    {
        $cooldownDays = Setting::get('cooldown_period', 14);
        
        $lastCompleted = $this->peminjamans()
            ->where('status', 'Selesai')
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->first();

        if (!$lastCompleted) {
            return true;
        }

        return now()->diffInDays($lastCompleted->completed_at) >= $cooldownDays;
    }

    public function nextBorrowDate()
    {
        $cooldownDays = Setting::get('cooldown_period', 14);
        
        $lastCompleted = $this->peminjamans()
            ->where('status', 'Selesai')
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->first();

        if (!$lastCompleted) {
            return null;
        }

        return $lastCompleted->completed_at->addDays($cooldownDays);
    }
}
