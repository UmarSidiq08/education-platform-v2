<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'class_id',
        'video_thumbnail',
        'is_published',
        'video_path',
        'video_url'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Get the class that owns the material.
     */
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Get the video URL for display.
     */
    public function getVideoUrlAttribute($value)
    {
        return $value;
    }

    /**
     * Get the full video file URL.
     */
    public function getVideoUrlForDisplayAttribute()
    {
        if ($this->video_path) {
            return asset("storage/{$this->video_path}"); // Path konsisten
        }
        return $this->video_url;
    }

    /**
     * Check if material has video content.
     */
    public function hasVideo()
    {
        return !empty($this->video_path) || !empty($this->video_url);
    }
    

    /**
     * Get video type (file or url).
     */
    public function getVideoType()
    {
        if ($this->video_path) {
            return 'file';
        } elseif ($this->video_url) {
            return 'url';
        }

        return null;
    }

    /**
     * Check if video is embeddable (YouTube, Vimeo).
     */
    public function isVideoEmbeddable()
    {
        if (!$this->video_url) {
            return false;
        }

        return strpos($this->video_url, 'youtube.com/embed/') !== false ||
            strpos($this->video_url, 'player.vimeo.com/video/') !== false;
    }
    public function getVideoThumbnailUrlAttribute()
    {
        if ($this->video_thumbnail) {
            return asset("storage/{$this->video_thumbnail}");
        }
        return asset('images/default-video-thumbnail.jpg');
    }
}
