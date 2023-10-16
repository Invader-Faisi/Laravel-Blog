<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'body',
        'active',
        'published_at',
        'user_id', 'meta_title', 'meta_description'
    ];

    protected $casts = ['published_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function shortBody()
    {
        return Str::words(strip_tags($this->body), 30);
    }

    public function getFormattedDate()
    {
        // dd($this->published_at);
        return $this->published_at->format('jS F Y');
    }

    public function getThumbnail()
    {
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        if ($this->thumbnail === null) {
            $this->thumbnail = 'default.jpg';
        }

        return '/storage/' . $this->thumbnail;
    }

    public function humanReadTime(): Attribute
    {
        return new Attribute(
            get: function ($value, $attributes) {
                $word = Str::wordCount(strip_tags($attributes['body']));
                $minutes = ceil($word / 200);
                return $minutes . ' ' . str('min')->plural($minutes) . ' , ' .
                    $word . ' ' . str('words')->plural($word);
            }
        );
    }
}
