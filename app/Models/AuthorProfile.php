<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorProfile extends Model
{
    use HasFactory, AutoUuid;

    protected $table = 'author_profiles';

    protected $fillable = [
        'user_id',
        'phone_number',
        'address',
        'income_id',
        'subsidy_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function householdIncome()
    {
        return $this->belongsTo(HouseholdIncome::class, 'income_id', 'id');
    }
}
