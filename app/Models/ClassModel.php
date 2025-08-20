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

    // Relasi ke Materials
    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    // Relasi ke PostTests (BARU)
    public function postTests()
{
    return $this->hasMany(PostTest::class, 'class_id'); // Pastikan foreign key benar
}

public function activePostTest()
{
    return $this->hasOne(PostTest::class, 'class_id')->where('is_active', true);
}
}
