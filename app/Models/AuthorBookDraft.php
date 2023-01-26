<?php

namespace App\Models;

use App\Traits\AutoUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorBookDraft extends Model
{
    use HasFactory, AutoUuid;

    protected $table = 'author_book_drafts';

    protected $fillable = [
        'user_id',
        'title',
        'context',
        'content',
        'count_pages',
        'url_book',
        'book_name',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
