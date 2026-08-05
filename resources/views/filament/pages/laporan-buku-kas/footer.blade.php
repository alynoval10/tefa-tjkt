<x-filament::section class="mt-6">

    <div class="flex justify-end">

        <table class="w-96">

            <tr>
                <td class="py-2 font-semibold">Total Kas Masuk</td>
                <td class="text-right">
                    Rp {{ number_format($summary['total_debet'],0,',','.') }}
                </td>
            </tr>

            <tr>
                <td class="py-2 font-semibold">Total Kas Keluar</td>
                <td class="text-right">
                    Rp {{ number_format($summary['total_kredit'],0,',','.') }}
                </td>
            </tr>

            <tr class="border-t">

                <td class="py-2 font-bold">
                    Saldo Akhir
                </td>

                <td class="text-right font-bold">
                    Rp {{ number_format($summary['saldo_akhir'],0,',','.') }}
                </td>

            </tr>

        </table>

    </div>

    <div class="mt-12 grid grid-cols-2 gap-20 text-center">

        <div>

            Mengetahui,<br>
            Kepala Program TJKT

            <div class="mt-20 font-semibold">
                (................................)
            </div>

        </div>

        <div>

            Bendahara TEFA

            <div class="mt-20 font-semibold">
                (................................)
            </div>

        </div>

    </div>

</x-filament::section>