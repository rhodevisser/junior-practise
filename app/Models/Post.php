<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static self create(array $attributes)
 */
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'status', 'user_id'];

    protected function getStatusAttribute($value): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
        );
    }

    public function scopePublished($query)
    {
       $query->where('status', 'published');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
       return $this->belongsToMany(Tag::class);
    }



}
