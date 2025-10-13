<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'teacher_class_id',
        'status',
        'message',
        'requested_at',
        'approved_at',
        'rejected_at',
        'approved_by',
        'request_origin' // TAMBAHAN INI YANG PENTING!
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Request origin constants untuk konsistensi
    const ORIGIN_REGISTRATION = 'registration';
    const ORIGIN_CLASS_PAGE = 'class_page';

    /**
     * Relasi ke User (mentor)
     */
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    /**
     * Relasi ke TeacherClass
     */
    public function teacherClass()
    {
        return $this->belongsTo(TeacherClass::class);
    }

    /**
     * Relasi ke User (approver - teacher)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope untuk status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope untuk status approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope untuk status rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Scope untuk request dari registrasi
     */
    public function scopeFromRegistration($query)
    {
        return $query->where('request_origin', self::ORIGIN_REGISTRATION);
    }

    /**
     * Scope untuk request dari halaman kelas
     */
    public function scopeFromClassPage($query)
    {
        return $query->where('request_origin', self::ORIGIN_CLASS_PAGE);
    }

    /**
     * Check if request is pending
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if request is approved
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if request is rejected
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Check if request is from registration
     */
    public function isFromRegistration()
    {
        return $this->request_origin === self::ORIGIN_REGISTRATION;
    }

    /**
     * Check if request is from class page
     */
    public function isFromClassPage()
    {
        return $this->request_origin === self::ORIGIN_CLASS_PAGE;
    }

    /**
     * Mark request as approved
     */
    public function approve($approvedBy = null)
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_at' => now(),
            'approved_by' => $approvedBy ?? auth()->id()
        ]);
    }

    /**
     * Mark request as rejected
     */
    public function reject()
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejected_at' => now()
        ]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get request origin text
     */
    public function getOriginTextAttribute()
    {
        return match ($this->request_origin) {
            self::ORIGIN_REGISTRATION => 'Dari Registrasi',
            self::ORIGIN_CLASS_PAGE => 'Dari Halaman Kelas',
            default => 'Tidak Diketahui'
        };
    }
}
