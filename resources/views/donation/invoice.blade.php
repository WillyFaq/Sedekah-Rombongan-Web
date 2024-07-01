<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice to {{ $donation->user->nama }}</title>

    <!-- Custom styles for this template-->
    <link href="{{ public_path('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ public_path('assets/css/style.css') }}" rel="stylesheet">
    <style>
        /* .donation-inv {
            width: 100%;
        } */
    </style>
</head>

<body>
    <div class="container p-0 pb-5 donation-inv">
        <div class="text-center p-4">
            <h2>Donasi</h2>
            <h3>{{ $donation->project->judul }}</h3>
        </div>
        <div class="py-4 text-center" style="background:#f1f5ff;">
            <p class="m-0">{{ $donation->no_invoice }} /
                {{ date('d M Y - H:i', strtotime($donation->created_at)) }}</p>
        </div>
        <div class="p-4 px-5 mx-2">
            <table class="table table-borderless">
                <tr>
                    <th width="35%">Nama</th>
                    <td width="1%">:</td>
                    <td>{{ $donation->user->nama }}</td>
                </tr>
                <tr>
                    <th>Anonim</th>
                    <td>:</td>
                    <td>{{ $donation->anonim ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>:</td>
                    <td>{{ $donation->user->email }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon</th>
                    <td>:</td>
                    <td>{{ $donation->user->nomor_telepon }}</td>
                </tr>
                <tr>
                    <th>Donasi</th>
                    <td>:</td>
                    <td>Rp. {{ number_format($donation->jumlah) }}</td>
                </tr>
            </table>
        </div>
        <div class="text-right p-4">
            <p>Surabaya, {{ date('d M Y') }}</p>
            <p><strong>SedekahRombongan</strong></p>
        </div>
    </div>
</body>

</html>
