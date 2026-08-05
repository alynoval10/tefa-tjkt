<x-filament::section class="mt-6">

    <div class="overflow-x-auto">

        <table class="w-full border border-gray-300 dark:border-gray-700">

            <thead class="bg-gray-100 dark:bg-gray-800">

                <tr>

                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Tanggal</th>
                    <th class="border px-3 py-2">No Bukti</th>
                    <th class="border px-3 py-2">Kategori</th>
                    <th class="border px-3 py-2">Keterangan</th>
                    <th class="border px-3 py-2 text-right">Debet</th>
                    <th class="border px-3 py-2 text-right">Kredit</th>
                    <th class="border px-3 py-2 text-right">Saldo</th>

                </tr>

            </thead>

            <tbody>

            @forelse($laporan as $index => $item)

                <tr>

                    <td class="border px-3 py-2">{{ $index + 1 }}</td>

                    <td class="border px-3 py-2">
                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $item['no_bukti'] }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $item['category']['name'] }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $item['keterangan'] }}
                    </td>

                    <td class="border px-3 py-2 text-right">

                        @if($item['debet'])
                            Rp {{ number_format($item['debet'],0,',','.') }}
                        @endif

                    </td>

                    <td class="border px-3 py-2 text-right">

                        @if($item['kredit'])
                            Rp {{ number_format($item['kredit'],0,',','.') }}
                        @endif

                    </td>

                    <td class="border px-3 py-2 text-right">

                        Rp {{ number_format($item['saldo'],0,',','.') }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="border px-3 py-4 text-center">
                        Tidak ada data.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</x-filament::section>