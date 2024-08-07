<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Kategori</x-pageheading>

    <x-card title="Data Kategori">
        <x-slot name="action">
            <a href="/category/create" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"
                title="Tambah"><i class="fas fa-plus"></i></a>
        </x-slot>
        <x-slot name="body">
            <div class="table-responsive">
                <table class="table table-hover dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Proyek</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    @if ($row->status == 0)
                                        <del>{{ $row->nama_kategori }}</del>
                                    @else
                                        {{ $row->nama_kategori }}
                                    @endif
                                </td>
                                <td>{{ $row->projects->where('status', '>', '0')->count() }}</td>
                                <td>
                                    <a href="/category/{{ $row->slug }}/edit" class="btn btn-sm btn-primary"
                                        data-toggle="tooltip" data-placement="top" title="Ubah"><i
                                            class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </x-slot>
    </x-card>
</x-layout>
