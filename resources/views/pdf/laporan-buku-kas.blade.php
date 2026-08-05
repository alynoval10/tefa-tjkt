<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
        }

        h2,
        h3 {
            margin: 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 6px;
        }

        th {
            background: #eee;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary {
            width: 40%;
            margin-left: auto;
            margin-top: 20px;
        }

        .ttd {
            margin-top: 60px;
            width: 100%;
        }

        .ttd td {
            border: none;
            text-align: center;
        }
    </style>

</head>

<body>

    <h2>LAPORAN BUKU KAS</h2>

    <h3>Teaching Factory TJKT</h3>

    <p>
        Periode :
        {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }}
        s/d
        {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}
    </p>

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Saldo</th>

            </tr>

        </thead>

        <tbody>

            @foreach($laporan as $i => $item)

                <tr>

                    <td class="center">{{ $i + 1 }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                    </td>

                    <td>{{ $item->no_bukti }}</td>

                    <td>{{ $item->category->name }}</td>

                    <td>{{ $item->keterangan }}</td>

                    <td class="right">

                        @if($item->debet)

                            {{ number_format($item->debet,0,',','.') }}

                        @endif

                    </td>

                    <td class="right">

                        @if($item->kredit)

                            {{ number_format($item->kredit,0,',','.') }}

                        @endif

                    </td>

                    <td class="right">

                        {{ number_format($item->saldo,0,',','.') }}

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <table class="summary">

        <tr>

            <td>Total Kas Masuk</td>

            <td class="right">
                {{ number_format($summary['total_debet'],0,',','.') }}
            </td>

        </tr>

        <tr>

            <td>Total Kas Keluar</td>

            <td class="right">
                {{ number_format($summary['total_kredit'],0,',','.') }}
            </td>

        </tr>

        <tr>

            <td><b>Saldo Akhir</b></td>

            <td class="right">
                <b>{{ number_format($summary['saldo_akhir'],0,',','.') }}</b>
            </td>

        </tr>

    </table>

    <table class="ttd">

        <tr>

            <td>

                Mengetahui,<br>
                Kepala Program TJKT

                <br><br><br><br>

                (...........................)

            </td>

            <td>

                Bendahara TEFA

                <br><br><br><br>

                (...........................)

            </td>

        </tr>

    </table>

</body>

</html>