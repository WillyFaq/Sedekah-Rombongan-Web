<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>

    <!-- Custom styles for this template-->
    {{-- public_path -> asset --}}
    <link href="{{ public_path('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ public_path('assets/css/style.css') }}" rel="stylesheet">
    <style>
        body,
        .table {
            color: #000;
        }

        .header {
            border-bottom: 2px solid #000;
        }

        .img-logo {
            width: 70px;
        }

        .info {
            text-align: center;
            padding: 10px;
        }

        .info>h1,
        .info>h2,
        .info>h3 {
            margin: 0;
            padding: 0;

        }

        .info>h1 {
            font-size: 1.75rem;
        }

        .info>h2 {
            font-size: 1.5rem;
        }

        .info>h3 {
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row header">
            <div class="col-xs-2">
                {{-- <img class="img-logo" src="{{ public_path('assets/imgs/icon-300.png') }}" alt="logo"> --}}
            </div>
            <div class="col">
                <div class="info">
                    <h2>Sedekah Rombongan</h2>
                    <h1>Laporan Rekap Proyek Donasi</h1>
                    <h3>Periode : {{ date('d M Y', strtotime($tgl_start)) }} s/d
                        {{ date('d M Y', strtotime($tgl_end)) }}</h3>
                </div>
            </div>
            <div class="col-xs-2"></div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-hover table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="40%">Proyek Donasi</th>
                        <th>Tanggal</th>
                        <th>Donasi</th>
                        <th>Donatur</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @php
                        $tot_donasi = 0;
                        $tot_donatur = 0;
                    @endphp
                    @foreach ($report as $i => $row)
                        @php
                            $donasi = $row->donations->sum('jumlah');
                            $tot_donasi += $donasi;
                            $donatur = $row->donations->count();
                            $tot_donatur += $donatur;
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                {{ $row->judul }} <br />
                                <small>{{ $row->lokasi }}</small>
                            </td>
                            <td>
                                {{ date('d M Y', strtotime($row->tgl_mulai)) }}
                            </td>
                            <td>
                                Rp. {{ number_format($donasi) }}
                            </td>
                            </td>
                            <td>
                                {{ number_format($donatur) }} Orang
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp. <span id="total_donation">{{ number_format($tot_donasi) }}</span>
                        </th>
                        <th>
                            <span id="total_donatur">{{ number_format($tot_donatur) }}</span> Orang
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
