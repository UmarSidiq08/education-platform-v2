<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
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

    /**
     * Relationship: Question belongs to Quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the correct answer text
     */
    public function getCorrectAnswerTextAttribute()
    {
        if (is_array($this->options) && isset($this->options[$this->correct_answer])) {
            return $this->options[$this->correct_answer];
        }
        return null;
    }

    /**
     * Get option by index
     */
    public function getOptionByIndex($index)
    {
        if (is_array($this->options) && isset($this->options[$index])) {
            return $this->options[$index];
        }
        return null;
    }
}
