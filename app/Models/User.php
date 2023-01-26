<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, AutoUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    public function adminProfile()
    {
        return $this->hasOne(AdminProfile::class, 'user_id', 'id');
    }

    public function authorProfile()
    {
        return $this->hasOne(AuthorProfile::class, 'user_id', 'id');
    }

    public function authorPayment()
    {
        return $this->hasMany(AuthorPayment::class, 'user_id', 'id');
    }

    public function authorTask()
    {
        return $this->hasOne(AuthorTask::class, 'user_id', 'id');
    }

    public function authorBook()
    {
        return $this->hasOne(AuthorBook::class, 'user_id', 'id');
    }

    public function authorBookDraft()
    {
        return $this->hasMany(AuthorBookDraft::class, 'user_id', 'id');
    }
}
