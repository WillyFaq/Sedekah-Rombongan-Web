<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Detail Donasi</x-pageheading>

    <x-card title="Data {{ $page_title }}"><x-slot name="action">
            <div>
                <a href="/donation/{{ $donation->id }}/invoice" class="btn btn-sm btn-danger" data-toggle="tooltip"
                    data-placement="top" title="Donwload Pdf" target="blank"><i class="fas fa-file-download"></i></a>
            </div>
        </x-slot>
        <x-slot name="body">
            <div class="container p-0 pb-5 donation-inv">
                <div class="text-center p-4">
                    <h2>Donasi</h2>
                    <h3>{{ $donation->project->judul }}</h3>
                </div>
                <div class="py-4 text-center" style="background:#f1f5ff;">
                    <p class="m-0">{{ $donation->no_invoice }} /
                        {{ date('d M Y - H:i', strtotime($donation->created_at)) }}</p>
                </div>
                <div class="p-4 px-5 mx-5">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
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
            </div>
        </x-slot>
    </x-card>
</x-layout>
