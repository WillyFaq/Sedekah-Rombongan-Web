<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Pengguna</x-pageheading>

    <x-card title="Data {{ $page_title }}">
        <x-slot name="action">
            <a href="/user/create" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"
                title="Tambah"><i class="fas fa-plus"></i></a>
        </x-slot>
        <x-slot name="body">
            <div class="table-responsive">
                <table class="table table-hover dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Alamat</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->nomor_telepon }}</td>
                                <td>{{ $row->alamat }}</td>
                                <td>
                                    <a href="/user/{{ $row->id }}/edit" class="btn btn-sm btn-primary"
                                        data-toggle="tooltip" data-placement="top" title="Ubah"><i
                                            class="fas fa-pencil-alt"></i></a>
                                    <form action="/user/{{ $row->id }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        @if ($row->status == 0)
                                            <button class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                data-placement="top" title="Pulihkan"
                                                onclick="return confirm('apakah anda yakin?')"><i
                                                    class="fas fa-recycle"></i></button>
                                        @else
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip"
                                                data-placement="top" title="Hapus"
                                                onclick="return confirm('apakah anda yakin?')"><i
                                                    class="fas fa-trash"></i></button>
                                        @endif
                                    </form>
                                    <a href="/user/{{ $row->id }}/reset" class="btn btn-sm btn-info"
                                        data-toggle="tooltip" data-placement="top" title="Reset Password"><i
                                            class="fas fa-user-lock"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-slot>
    </x-card>
</x-layout>
