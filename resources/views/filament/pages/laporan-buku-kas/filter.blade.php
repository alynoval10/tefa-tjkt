<x-filament::section>

    <form wire:submit="loadData">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tanggal Awal
                </label>

                <input
                    type="date"
                    wire:model="tanggalAwal"
                    class="fi-input w-full rounded-lg"
                >
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tanggal Akhir
                </label>

                <input
                    type="date"
                    wire:model="tanggalAkhir"
                    class="fi-input w-full rounded-lg"
                >
            </div>

            <div class="flex items-end">

                <x-filament::button
                    type="submit"
                    icon="heroicon-o-funnel"
                >
                    Tampilkan
                </x-filament::button>

            </div>

        </div>

    </form>

</x-filament::section>