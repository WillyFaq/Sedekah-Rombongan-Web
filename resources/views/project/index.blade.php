<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Proyek Donasi</x-pageheading>

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
                            <th width="20%">Judul</th>
                            <th>Kategori</th>
                            <th width="23%">Donasi</th>
                            <th>Tanggal Mulai</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    {{ $row->judul }} <br />
                                    <small>{{ $row->lokasi }}</small>
                                </td>
                                <td>{{ $row->category->nama_kategori }}</td>
                                <td>
                                    @php
                                        $jmlh = $row->donations->sum('jumlah');
                                        $tot = $row->target_dana;
                                    @endphp
                                    Rp. {{ number_format($jmlh) }}
                                    /
                                    Rp. {{ number_format($tot) }}
                                    <br>
                                    <x-progressbar jumlah="{{ $jmlh }}" total="{{ $tot }}" />
                                </td>
                                <td>
                                    {{ date('d M Y', strtotime($row->tgl_mulai)) }}
                                </td>
                                <td>
                                    <a href="/project/{{ $row->slug }}" class="btn btn-sm btn-info"
                                        data-toggle="tooltip" data-placement="top" title="Detail"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="/project/{{ $row->slug }}/edit" class="btn btn-sm btn-primary"
                                        data-toggle="tooltip" data-placement="top" title="Ubah"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <form action="/project/{{ $row->slug }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top"
                                            title="Hapus" onclick="return confirm('apakah anda yakin?')"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </x-slot>
    </x-card>
</x-layout>
