<?php

namespace App\Actions\Kas;

use App\Models\Category;
use App\Models\Kas;
use Carbon\Carbon;
use App\Enums\TransactionType;
class GenerateNoBukti
{
    public function execute(int $categoryId, string $tanggal): array
    {
        $category = Category::findOrFail($categoryId);

        $type = TransactionType::from($category->type);

        $prefix = $type->prefix();

        $date = Carbon::parse($tanggal);

        $periode = $date->format('Ym');

        $lastNomor = Kas::whereHas('category', function ($q) use ($category) {
                $q->where('type', $category->type);
            })
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->max('nomor_urut');

        $nomor = ($lastNomor ?? 0) + 1;

        return [
            'nomor_urut' => $nomor,
            'no_bukti' => sprintf(
                '%s-%s-%06d',
                $prefix,
                $periode,
                $nomor
            ),
        ];
    }
}