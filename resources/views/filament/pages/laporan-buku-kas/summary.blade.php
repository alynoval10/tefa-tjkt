<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

    <x-filament::section>

        <div class="text-sm text-gray-500">
            Total Kas Masuk
        </div>

        <div class="text-2xl font-bold text-success-600 mt-2">
            Rp {{ number_format($summary['total_debet'] ?? 0,0,',','.') }}
        </div>

    </x-filament::section>

    <x-filament::section>

        <div class="text-sm text-gray-500">
            Total Kas Keluar
        </div>

        <div class="text-2xl font-bold text-danger-600 mt-2">
            Rp {{ number_format($summary['total_kredit'] ?? 0,0,',','.') }}
        </div>

    </x-filament::section>

    <x-filament::section>

        <div class="text-sm text-gray-500">
            Saldo Akhir
        </div>

        <div class="text-2xl font-bold text-primary-600 mt-2">
            Rp {{ number_format($summary['saldo_akhir'] ?? 0,0,',','.') }}
        </div>

    </x-filament::section>

</div>