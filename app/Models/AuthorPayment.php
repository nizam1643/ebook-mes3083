<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorPayment extends Model
{
    use HasFactory, AutoUuid;

    protected $fillable = [
        'user_id',
        'author_package_id',
        'payment_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function authorPackage()
    {
        return $this->belongsTo(AuthorPackage::class, 'author_package_id', 'id');
    }
}
