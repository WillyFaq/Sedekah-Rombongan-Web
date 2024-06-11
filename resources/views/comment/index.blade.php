<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Komentar</x-pageheading>

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
                            <th width="20%">Proyek Donasi</th>
                            <th>Pengguna</th>
                            <th>Isi Komentar</th>
                            <th>Tanggal Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    {{ $row->project->judul }}
                                </td>
                                <td>{{ $row->user->nama }}</td>
                                <td>{{ $row->isi_komentar }}</td>
                                <td>
                                    {{ date('d M Y H:i:s', strtotime($row->created_at)) }}
                                </td>
                                <td>
                                    <form action="/comment/{{ $row->id }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        @if ($row->status == 1)
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                data-placement="top" title="Sembunyikan"
                                                onclick="return confirm('apakah anda yakin?')"><i
                                                    class="fas fa-eye-slash"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-info" data-toggle="tooltip"
                                                data-placement="top" title="Tampilkan"
                                                onclick="return confirm('apakah anda yakin?')"><i
                                                    class="fas fa-eye"></i></button>
                                        @endif
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
