<?php

namespace App\Models;

use App\Observers\InteractionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'interaction_type',
    ];

    protected static function booted(): void
    {
        static::observe(InteractionObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
