<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Kategori</x-pageheading>
    <x-card title="{{ $page_title }}">
        <x-slot name="body">
            <form method="post" action="/category/{{ $category->slug }}">
                @method('put')
                @csrf
                <div class="form-group">
                    <label for="nama_kategori">Nama Ketegori</label>
                    <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                        id="nama_kategori" name="nama_kategori" required autofocus
                        value="{{ old('nama_kategori', $category->nama_kategori) }}">
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </x-slot>
    </x-card>
</x-layout>
