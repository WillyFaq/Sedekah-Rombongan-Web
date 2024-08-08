<x-layout>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/attachments.js') }}"></script>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Proyek Donasi</x-pageheading>
    <x-card title="{{ $page_title }}">
        <x-slot name="body">
            <form method="post" action="/project" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                        name="judul" required autofocus value="{{ old('judul') }}">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id" required>
                                <option value="">[Pilih Kategori]</option>
                                @foreach ($categories as $category)
                                    @if (old('category_id') == $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->nama_kategori }}
                                        </option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->nama_kategori }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="target_dana">Target Dana</label>
                            <div class="input-group mb-3 @error('target_dana') is-invalid @enderror">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="target_dana-addon">Rp.</span>
                                </div>
                                <input type="number" min="0" max="1e12"
                                    class="form-control @error('target_dana') is-invalid @enderror" id="target_dana"
                                    name="target_dana" required value="{{ old('target_dana') }}"
                                    aria-label="target_dana" aria-describedby="target_dana-addon">
                            </div>
                            @error('target_dana')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend @error('target_dana') is-invalid @enderror">
                                    <span class="input-group-text" id="lokasi-addon">
                                        &nbsp;<i class="fas fa-map-marker-alt"></i>&nbsp;
                                    </span>
                                </div>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi" required value="{{ old('lokasi') }}"
                                    aria-label="lokasi" aria-describedby="lokasi-addon">
                            </div>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tgl_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror"
                                id="tgl_mulai" name="tgl_mulai" required value="{{ old('tgl_mulai') }}">
                            @error('tgl_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tgl_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror"
                                id="tgl_selesai" name="tgl_selesai" required value="{{ old('tgl_selesai') }}">
                            @error('tgl_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            {{-- <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                              id="gambar" name="gambar" required value="{{ old('gambar') }}"> --}}

                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror"
                                    id="gambar" name="image">
                                <label class="custom-file-label" for="gambar">Choose file</label>
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-4 text-center">
                                <img class="imgres" id="img-preview" src="https://placehold.co/320?text=Placeholder"
                                    alt="image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    @error('deskripsi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <input id="deskripsi" type="text" style="display: none" name="deskripsi"
                        value="{{ old('deskripsi') }}">
                    <trix-editor input="deskripsi"></trix-editor>

                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </x-slot>
    </x-card>
    <script type="text/javascript">
        $(document).ready(function() {
            console.log("ready");
            $('#gambar').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#img-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</x-layout>
