<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function last_notifications()
    {
        $notifications = Notification::where('user_id', $this->id)
            ->orderBy('created_at', 'asc')
            ->paginate(3);
        return $notifications;
    }

    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    // public function notif_numb()
    // {
    //     return $this->hasOne(BadgeNotification::class)->number;
    // }

    public function unreadNotifications()
{
    return $this->notifications()->where('read_at', null);
}
}
