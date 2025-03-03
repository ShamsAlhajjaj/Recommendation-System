<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    public function likes()
    {
        return $this->interactions()->where('interaction_type', 'like');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
