<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorTask extends Model
{
    use HasFactory, AutoUuid;

    protected $fillable = [
        'user_id',
        'task_allotted',
        'task_consumed',
        'task_remaining',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
