<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Laporan Keuangan</title>

    <style>
        @page {
            margin: 35px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0 0;
            font-size: 13px;
            font-weight: normal;
        }

        .periode {
            margin-top: 8px;
            font-size: 10px;
            color: #555;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .summary td {
            width: 33.33%;
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }

        .summary-label {
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 13px;
            font-weight: bold;
        }

        .income {
            color: #15803d;
        }

        .expense {
            color: #b91c1c;
        }

        .balance {
            color: #1d4ed8;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table.data th {
            background: #f0f0f0;
            border: 1px solid #ccc;
            padding: 7px;
            text-align: left;
            font-size: 9px;
        }

        table.data td {
            border: 1px solid #ccc;
            padding: 7px;
            font-size: 9px;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background: #f7f7f7;
        }

        .footer {
            margin-top: 35px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}

    <div class="header">

        <h1>LAPORAN KEUANGAN</h1>

        <h2>TEFA TJKT</h2>

        <div class="periode">
            Periode:
            {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}
            -
            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}
        </div>

    </div>


    {{-- RINGKASAN --}}

    <table class="summary">

        <tr>

            <td>

                <div class="summary-label">
                    KAS MASUK
                </div>

                <div class="summary-value income">
                    Rp {{ number_format($totalMasuk, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    KAS KELUAR
                </div>

                <div class="summary-value expense">
                    Rp {{ number_format($totalKeluar, 0, ',', '.') }}
                </div>

            </td>


            <td>

                <div class="summary-label">
                    SALDO
                </div>

                <div class="summary-value balance">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </div>

            </td>

        </tr>

    </table>


    {{-- REKAP KATEGORI --}}

    <div class="section-title">
        REKAPITULASI KATEGORI
    </div>


    @if($rekapKategori->count())

        <table class="data">

            <thead>

                <tr>

                    <th style="width: 50%;">
                        Kategori
                    </th>

                    <th style="width: 20%;">
                        Tipe
                    </th>

                    <th style="width: 30%;" class="text-right">
                        Jumlah
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($rekapKategori as $item)

                    <tr>

                        <td>
                            {{ $item['kategori'] }}
                        </td>

                        <td>
                            {{ $item['type'] === 'income'
                                ? 'Kas Masuk'
                                : 'Kas Keluar'
                            }}
                        </td>

                        <td class="text-right">

                            Rp
                            {{ number_format(
                                (float) $item['jumlah'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </td>

                    </tr>

                @endforeach


                <tr class="total">

                    <td colspan="2">
                        TOTAL
                    </td>

                    <td class="text-right">
                        Rp {{ number_format(
                            $totalMasuk + $totalKeluar,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                </tr>

            </tbody>

        </table>

    @else

        <p>
            Tidak ada transaksi pada periode yang dipilih.
        </p>

    @endif


    {{-- RINGKASAN AKHIR --}}

    <div class="section-title">
        RINGKASAN KEUANGAN
    </div>


    <table class="data">

        <tbody>

            <tr>
                <td>
                    Total Kas Masuk
                </td>

                <td class="text-right income">
                    Rp {{ number_format(
                        $totalMasuk,
                        0,
                        ',',
                        '.'
                    ) }}
                </td>
            </tr>


            <tr>
                <td>
                    Total Kas Keluar
                </td>

                <td class="text-right expense">
                    Rp {{ number_format(
                        $totalKeluar,
                        0,
                        ',',
                        '.'
                    ) }}
                </td>
            </tr>


            <tr class="total">

                <td>
                    Saldo Akhir
                </td>

                <td class="text-right balance">
                    Rp {{ number_format(
                        $saldo,
                        0,
                        ',',
                        '.'
                    ) }}
                </td>

            </tr>

        </tbody>

    </table>


    {{-- FOOTER --}}

    <div class="footer">

        Dicetak pada:
        {{ now()->format('d/m/Y H:i') }}

    </div>

</body>
</html>