<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'mentor_id'
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
    // Relasi ke User (mentor)
    public function materials()
{
    // Mengarah ke model Material, foreign key = class_id
    return $this->hasMany(Material::class, 'class_id');
}

}
