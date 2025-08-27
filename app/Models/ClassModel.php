<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClassModel (ImplementationClass)
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $mentor_id
 * @property int|null $teacher_class_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * // Dynamic properties added during runtime (for achievements)
 * @property \App\Models\PostTestAttempt|null $best_attempt
 * @property \Carbon\Carbon|null $completion_date
 * @property int|null $score
 * @property float|null $percentage
 * @property int|null $total_materials
 *
 * // Relationships
 * @property \App\Models\User $mentor
 * @property \App\Models\TeacherClass|null $teacherClass
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Material[] $materials
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\PostTest[] $postTests
 * @property \App\Models\PostTest|null $activePostTest
 */
class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'mentor_id',
        'teacher_class_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke User (mentor)
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    // Relasi ke TeacherClass (baru)
    public function teacherClass()
    {
        return $this->belongsTo(TeacherClass::class);
    }

    // Relasi ke Materials
    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    // Relasi ke PostTests
    public function postTests()
    {
        return $this->hasMany(PostTest::class, 'class_id');
    }

    public function activePostTest()
    {
        return $this->hasOne(PostTest::class, 'class_id')->where('is_active', true);
    }

    /**
     * Get full class name with teacher context
     */
    public function getFullNameAttribute()
    {
        if ($this->teacherClass) {
            return $this->name . ' (' . $this->teacherClass->full_name . ')';
        }

        return $this->name . ' by ' . $this->mentor->name;
    }

    /**
     * Check if this is a legacy class (created before teacher class system)
     */
    public function isLegacy()
    {
        return $this->teacher_class_id === null;
    }

    /**
     * Scope for classes under specific teacher class
     */
    public function scopeUnderTeacherClass($query, $teacherClassId)
    {
        return $query->where('teacher_class_id', $teacherClassId);
    }

    /**
     * Scope for legacy classes (no teacher class)
     */
    public function scopeLegacy($query)
    {
        return $query->whereNull('teacher_class_id');
    }

    /**
     * Set dynamic achievement properties
     * This method helps with IDE autocompletion and type hints
     */
    public function setAchievementData($bestAttempt, $totalMaterials = null)
    {
        $this->best_attempt = $bestAttempt;
        $this->completion_date = $bestAttempt->finished_at;
        $this->score = $bestAttempt->score;
        $this->percentage = $bestAttempt->getPercentageAttribute();

        if ($totalMaterials !== null) {
            $this->total_materials = $totalMaterials;
        }

        return $this;
    }
}
