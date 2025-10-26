<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'author',
        'content',
        'status',
    ];

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Get the markdown-rendered excerpt of the content.
     */
    public function getExcerptAttribute(): string
    {
    $html = Str::of($this->content ?? '')->markdown()->toString();

        return Str::limit(trim(strip_tags($html)), 200);
    }

    /**
     * Get the markdown-rendered content as HTML.
     */
    public function getContentHtmlAttribute(): string
    {
    return Str::of($this->content ?? '')->markdown()->toString();
    }

    /**
     * Estimate reading time for the article.
     */
    public function getReadingTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $minutes = (int) max(1, ceil($wordCount / 200));

        return $minutes.' menit';
    }
}
