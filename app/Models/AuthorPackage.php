<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorPackage extends Model
{
    use HasFactory, AutoUuid;

    protected $table = 'author_packages';

    protected $fillable = [
        'name',
        'sub_name',
        'price',
        'task'
    ];

    public function payments()
    {
        return $this->hasMany(AuthorPayment::class, 'author_package_id', 'id');
    }
}
