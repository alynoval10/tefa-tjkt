<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;

    protected $table = 'kas';

    protected $fillable = [
        'no_bukti',
        'nomor_urut',
        'tanggal',
        'category_id',
        'nominal',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateNoBukti(int $categoryId, string $tanggal): array
    {
        $category = Category::findOrFail($categoryId);

        $prefix = $category->type === 'income' ? 'KM' : 'KK';

        $date = Carbon::parse($tanggal);

        $periode = $date->format('Ym');

        $lastNomor = self::whereHas('category', function ($q) use ($category) {
                $q->where('type', $category->type);
            })
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->max('nomor_urut');

        $nomor = ($lastNomor ?? 0) + 1;

        return [
            'nomor_urut' => $nomor,
            'no_bukti' => sprintf('%s-%s-%06d', $prefix, $periode, $nomor),
        ];
    }
}