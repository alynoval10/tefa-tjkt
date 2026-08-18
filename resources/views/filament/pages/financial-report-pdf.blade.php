<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Keuangan</title>

    <style>

        @page {
            margin: 30px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }


        /*
        |--------------------------------------------------------------------------
        | KOP
        |--------------------------------------------------------------------------
        */

        .kop {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .kop td {
            vertical-align: middle;
        }

        .logo-left {
            width: 80px;
            text-align: left;
        }

        .logo-right {
            width: 80px;
            text-align: right;
        }

        .logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .kop-tengah {
            text-align: center;
            padding: 0 10px;
        }

        .nama-sekolah {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .nama-tefa {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .jurusan {
            font-size: 10px;
        }

        .alamat {
            font-size: 8px;
            color: #555;
            margin-top: 4px;
        }


        .garis-kop {
            border-bottom: 2px solid #222;
            margin-bottom: 18px;
        }


        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .periode {
            margin-top: 7px;
            font-size: 10px;
            color: #555;
        }


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SECTION
        |--------------------------------------------------------------------------
        */

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }


        /*
        |--------------------------------------------------------------------------
        | TABLE
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | TANDA TANGAN
        |--------------------------------------------------------------------------
        */

        .signature {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        .signature td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .signature-space {
            height: 55px;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 8px;
            color: #666;
        }

    </style>

</head>


<body>


    {{-- ==========================================================
         KOP LAPORAN
    =========================================================== --}}

    <table class="kop">

        <tr>


            {{-- LOGO SEKOLAH --}}

            <td class="logo-left">

                @if(!empty($schoolLogo))

                    <img
                        src="{{ $schoolLogo }}"
                        class="logo"
                    >

                @endif

            </td>


            {{-- IDENTITAS --}}

            <td class="kop-tengah">

                <div class="nama-sekolah">

                    {{ $setting->school_name ?? 'SMKN 1 Krangkeng' }}

                </div>


                <div class="nama-tefa">

                    {{ $setting->tefa_name ?? 'Teaching Factory TJKT' }}

                </div>


                <div class="jurusan">

                    {{ $setting->department_name
                        ?? 'Teknik Jaringan Komputer dan Telekomunikasi'
                    }}

                </div>


                @if(!empty($setting->address))

                    <div class="alamat">

                        {{ $setting->address }}

                        @if(!empty($setting->phone))
                            | Telp. {{ $setting->phone }}
                        @endif

                        @if(!empty($setting->email))
                            | {{ $setting->email }}
                        @endif

                    </div>

                @endif

            </td>


            {{-- LOGO TEFA --}}

            <td class="logo-right">

                @if(!empty($tefaLogo))

                    <img
                        src="{{ $tefaLogo }}"
                        class="logo"
                    >

                @endif

            </td>

        </tr>

    </table>


    <div class="garis-kop"></div>


    {{-- ==========================================================
         JUDUL
    =========================================================== --}}

    <div class="header">

        <h1>
            LAPORAN KEUANGAN
        </h1>


        <div class="periode">

            Periode:

            {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}

            -

            {{ \Carbon\Carbon::parse($tanggalSelesai)->format('d/m/Y') }}

        </div>

    </div>


    {{-- ==========================================================
         RINGKASAN
    =========================================================== --}}

    <table class="summary">

        <tr>


            <td>

                <div class="summary-label">
                    KAS MASUK
                </div>

                <div class="summary-value income">

                    Rp
                    {{ number_format(
                        $totalMasuk,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </td>


            <td>

                <div class="summary-label">
                    KAS KELUAR
                </div>

                <div class="summary-value expense">

                    Rp
                    {{ number_format(
                        $totalKeluar,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </td>


            <td>

                <div class="summary-label">
                    SALDO
                </div>

                <div class="summary-value balance">

                    Rp
                    {{ number_format(
                        $saldo,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

            </td>

        </tr>

    </table>


    {{-- ==========================================================
         REKAP KATEGORI
    =========================================================== --}}

    <div class="section-title">

        REKAPITULASI KATEGORI

    </div>


    @if($rekapKategori->count())


        <table class="data">

            <thead>

                <tr>

                    <th style="width:50%;">
                        Kategori
                    </th>

                    <th style="width:20%;">
                        Tipe
                    </th>

                    <th
                        style="width:30%;"
                        class="text-right"
                    >
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

                        Rp
                        {{ number_format(
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

            Tidak ada transaksi pada periode
            yang dipilih.

        </p>


    @endif



    {{-- ==========================================================
         RINGKASAN AKHIR
    =========================================================== --}}

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

                    Rp
                    {{ number_format(
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

                    Rp
                    {{ number_format(
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

                    Rp
                    {{ number_format(
                        $saldo,
                        0,
                        ',',
                        '.'
                    ) }}

                </td>

            </tr>


        </tbody>

    </table>



    {{-- ==========================================================
         TANDA TANGAN
    =========================================================== --}}

    <table class="signature">

        <tr>


            <td>

                Kepala Program

                <div class="signature-space"></div>


                @if($setting->headProgram)

                    <div class="signature-name">

                        {{ $setting->headProgram->name }}

                    </div>

                @else

                    <div>
                        __________________________
                    </div>

                @endif

            </td>


            <td>

                Bendahara

                <div class="signature-space"></div>


                @if($setting->treasurer)

                    <div class="signature-name">

                        {{ $setting->treasurer->name }}

                    </div>

                @else

                    <div>
                        __________________________
                    </div>

                @endif

            </td>


        </tr>

    </table>



    {{-- ==========================================================
         FOOTER
    =========================================================== --}}

    <div class="footer">

        Dicetak pada:

        {{ now()->format('d/m/Y H:i') }}

    </div>


</body>

</html>