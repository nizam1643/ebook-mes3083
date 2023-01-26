<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdIncome extends Model
{
    use HasFactory, AutoUuid;

    protected $table = 'household_incomes';

    protected $fillable = [
        'name',
        'discount'
    ];

    public function authorProfiles()
    {
        return $this->hasMany(AuthorProfile::class, 'income_id', 'id');
    }
}
