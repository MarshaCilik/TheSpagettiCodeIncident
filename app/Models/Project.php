<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'judul',
        'deskripsi',
        'kategori',
        'budget_min',
        'budget_max',
        'batas_lelang',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'budget_min' => 'integer',
            'budget_max' => 'integer',
            'batas_lelang' => 'date',
        ];
    }

    /**
     * Klien pemilik proyek.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Semua tawaran (bids) yang masuk untuk proyek ini.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'project_id');
    }

    /**
     * Penawaran yang menjadi pemenang lelang (jika ada).
     */
    public function winningBid()
    {
        return $this->hasOne(Bid::class, 'project_id')->where('is_winner', true);
    }

    /**
     * Scope untuk proyek yang masih terbuka.
     */
    public function scopeTerbuka($query)
    {
        return $query->where('status', 'terbuka');
    }

    /**
     * Scope untuk proyek yang sudah ditutup.
     */
    public function scopeDitutup($query)
    {
        return $query->where('status', 'ditutup');
    }
}
