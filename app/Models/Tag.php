<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use hasFactory;
    protected $fillable = [];

    public function post(): void
    {
        $this->belongsToMany(Post::class);
    }
}
