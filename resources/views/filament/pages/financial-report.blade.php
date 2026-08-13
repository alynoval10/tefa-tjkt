<x-filament-panels::page>

    @php
        $totalMasuk = $this->getTotalMasuk();
        $totalKeluar = $this->getTotalKeluar();
        $saldo = $this->getSaldo();
        $rekapKategori = $this->getRekapKategori();
    @endphp

    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- PERIODE --}}
        <div style="
            border:1px solid #27272a;
            border-radius:12px;
            background:#18181b;
            padding:20px;
        ">

            <div style="
                font-size:15px;
                font-weight:600;
                color:#fff;
                margin-bottom:15px;
            ">
                Periode Laporan
            </div>

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:15px;
            ">

                <div>
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:12px;
                        color:#a1a1aa;
                    ">
                        Dari
                    </label>

                    <input
                        type="date"
                        wire:model.live="tanggalMulai"
                        style="
                            width:100%;
                            border:1px solid #3f3f46;
                            border-radius:8px;
                            background:#09090b;
                            color:#fff;
                            padding:9px 11px;
                        "
                    >
                </div>

                <div>
                    <label style="
                        display:block;
                        margin-bottom:6px;
                        font-size:12px;
                        color:#a1a1aa;
                    ">
                        Sampai
                    </label>

                    <input
                        type="date"
                        wire:model.live="tanggalSelesai"
                        style="
                            width:100%;
                            border:1px solid #3f3f46;
                            border-radius:8px;
                            background:#09090b;
                            color:#fff;
                            padding:9px 11px;
                        "
                    >
                </div>

            </div>

        </div>


        {{-- RINGKASAN --}}
        <div style="
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:15px;
        ">

            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">
                <div style="font-size:12px;color:#a1a1aa;">
                    Kas Masuk
                </div>

                <div style="
                    margin-top:8px;
                    font-size:20px;
                    font-weight:700;
                    color:#4ade80;
                ">
                    {{ $this->formatRupiah($totalMasuk) }}
                </div>
            </div>


            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">
                <div style="font-size:12px;color:#a1a1aa;">
                    Kas Keluar
                </div>

                <div style="
                    margin-top:8px;
                    font-size:20px;
                    font-weight:700;
                    color:#f87171;
                ">
                    {{ $this->formatRupiah($totalKeluar) }}
                </div>
            </div>


            <div style="
                border:1px solid #27272a;
                border-radius:12px;
                background:#18181b;
                padding:20px;
            ">
                <div style="font-size:12px;color:#a1a1aa;">
                    Saldo
                </div>

                <div style="
                    margin-top:8px;
                    font-size:20px;
                    font-weight:700;
                    color:#60a5fa;
                ">
                    {{ $this->formatRupiah($saldo) }}
                </div>
            </div>

        </div>


        {{-- REKAP KATEGORI --}}
        <div style="
            overflow:hidden;
            border:1px solid #27272a;
            border-radius:12px;
            background:#18181b;
        ">

            <div style="
                padding:18px 20px;
                border-bottom:1px solid #27272a;
            ">
                <div style="
                    font-size:15px;
                    font-weight:600;
                    color:#fff;
                ">
                    Rekap Kategori
                </div>

                <div style="
                    margin-top:4px;
                    font-size:12px;
                    color:#71717a;
                ">
                    Ringkasan transaksi berdasarkan kategori
                </div>
            </div>


            @if($rekapKategori->count())

                <div style="overflow-x:auto;">

                    <table style="
                        width:100%;
                        border-collapse:collapse;
                        font-size:13px;
                    ">

                        <thead>
                            <tr style="
                                border-bottom:1px solid #27272a;
                                color:#a1a1aa;
                            ">

                                <th style="
                                    padding:12px 20px;
                                    text-align:left;
                                ">
                                    Kategori
                                </th>

                                <th style="
                                    padding:12px;
                                    text-align:left;
                                ">
                                    Tipe
                                </th>

                                <th style="
                                    padding:12px 20px;
                                    text-align:right;
                                ">
                                    Jumlah
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            @foreach($rekapKategori as $item)

                                <tr style="
                                    border-bottom:1px solid #27272a;
                                ">

                                    <td style="
                                        padding:12px 20px;
                                        color:#fff;
                                        font-weight:600;
                                    ">
                                        {{ $item['kategori'] }}
                                    </td>

                                    <td style="padding:12px;">

                                        @if($item['type'] === 'income')

                                            <span style="
                                                display:inline-block;
                                                padding:4px 8px;
                                                border-radius:6px;
                                                font-size:11px;
                                                font-weight:600;
                                                background:rgba(34,197,94,.10);
                                                color:#4ade80;
                                            ">
                                                Masuk
                                            </span>

                                        @else

                                            <span style="
                                                display:inline-block;
                                                padding:4px 8px;
                                                border-radius:6px;
                                                font-size:11px;
                                                font-weight:600;
                                                background:rgba(239,68,68,.10);
                                                color:#f87171;
                                            ">
                                                Keluar
                                            </span>

                                        @endif

                                    </td>

                                    <td style="
                                        padding:12px 20px;
                                        text-align:right;
                                        color:#fff;
                                        font-weight:600;
                                    ">
                                        {{ $this->formatRupiah((float) $item['jumlah']) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div style="
                    padding:40px;
                    text-align:center;
                    color:#71717a;
                    font-size:13px;
                ">
                    Tidak ada transaksi pada periode yang dipilih.
                </div>

            @endif

        </div>

    </div>

</x-filament-panels::page>