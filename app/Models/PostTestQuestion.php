<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_test_id',
        'question',
        'image',
        'options',
        'correct_answer',
        'points',
        'order'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'integer',
        'points' => 'integer',
        'order' => 'integer'
    ];

    public function postTest()
    {
        return $this->belongsTo(PostTest::class);
    }
}
