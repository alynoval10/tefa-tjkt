<x-filament-panels::page>

    <div class="text-center mb-6">

        <h2 class="text-2xl font-bold">
            LAPORAN BUKU KAS
        </h2>

        <p class="text-gray-500">
            Teaching Factory TJKT
        </p>

    </div>

    @include('filament.pages.laporan-buku-kas.filter')

    @include('filament.pages.laporan-buku-kas.summary')

    @include('filament.pages.laporan-buku-kas.table')

    @include('filament.pages.laporan-buku-kas.footer')

</x-filament-panels::page>