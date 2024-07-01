<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Donasi</x-pageheading>

    <x-card title="Data {{ $page_title }}">
        <x-slot name="action">
            <a href="/project/create" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"
                title="Tambah"><i class="fas fa-plus"></i></a>
        </x-slot>
        <x-slot name="body">
            <div class="table-responsive">
                <table class="table table-hover dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th width="20%">Proyek Donasi</th>
                            <th width="20%">Donatur</th>
                            <th>Jumlah</th>
                            <th>Tanggal Donasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    {{ $row->no_invoice }}
                                </td>
                                <td>
                                    {{ $row->project->judul }}
                                </td>
                                <td>{{ $row->user->nama }}</td>
                                <td>
                                    Rp. {{ number_format($row->jumlah) }}
                                </td>
                                <td>
                                    {{ date('d M Y H:i:s', strtotime($row->created_at)) }}
                                </td>
                                <td>
                                    <a href="/donation/{{ $row->id }}" class="btn btn-sm btn-info"
                                        data-toggle="tooltip" data-placement="top" title="Detail"><i
                                            class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-slot>
    </x-card>
</x-layout>
