<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Proyek Donasi</x-pageheading>

    <x-card title="Data {{ $page_title }}">
        <x-slot name="action">
            <div>
                <a href="/project/{{ $project->slug }}/edit" class="btn btn-sm btn-primary" data-toggle="tooltip"
                    data-placement="top" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                <form action="/project/{{ $project->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"
                        onclick="return confirm('apakah anda yakin?')"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </x-slot>
        <x-slot name="body">
            <div class="pb-4 text-center" style="width:100%;">
                @php
                    $gambar = $project->gambar;
                    if (Str::substr($gambar, 0, 5) != 'https') {
                        $gambar = asset("storage/$gambar");
                    }
                @endphp
                <img class="imgres" src="{{ $gambar }}" alt="gambar-{{ $project->slug }}">
            </div>
            <h3>{{ $project->judul }}</h3>
            <p><i class="fas fa-map-marker-alt"></i> {{ $project->lokasi }}</p>
            <div class="border-top border-bottom border-dark p-4 mb-4">
                <p>
                    @php
                        $jmlh = $project->donations->sum('jumlah');
                        $tot = $project->target_dana;
                    @endphp
                    <strong>Rp. {{ number_format($jmlh) }}</strong>
                    <small>
                        terkumpul dari
                        <strong>Rp. {{ number_format($tot) }}</strong>
                    </small>
                </p>
                <x-progressbar jumlah="{{ $jmlh }}" total="{{ $tot }}" />
                <p class="mt-2"><small><strong>{{ $project->donations->count() }}</strong> Donasi</small></p>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-toggle="tab" data-target="#description"
                        type="button" role="tab" aria-controls="description"
                        aria-selected="true">Deskripsi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comment-tab" data-toggle="tab" data-target="#comment" type="button"
                        role="tab" aria-controls="comment" aria-selected="false">Komentar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="donation-tab" data-toggle="tab" data-target="#donation" type="button"
                        role="tab" aria-controls="donation" aria-selected="false">Donatur</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel"
                    aria-labelledby="description-tab">
                    <div class="detail_project p-4 mb-4">
                        {!! $project->deskripsi !!}
                    </div>
                </div>
                <div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="comment-tab">
                    <div class="bg-gray-200 p-4">
                        @foreach ($project->comments as $comment)
                            @php
                                $name = $comment->anonim ? 'Sedekaholic' : $comment->user->nama;
                            @endphp
                            <div class="card shadow mb-4">
                                <x-media name="{{ $name }}" time="{{ $comment->created_at->diffForHumans() }}"
                                    amin="{{ $comment->amin }}">
                                    {{ $comment->isi_komentar }}
                                </x-media>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="donation" role="tabpanel" aria-labelledby="donation-tab">
                    <div class="bg-gray-200 p-4">
                        @foreach ($project->donations as $donation)
                            @php
                                $name = $donation->anonim ? 'Sedekaholic' : $donation->user->nama;
                            @endphp
                            <div class="card shadow mb-4">
                                <x-media name="{{ $name }}"
                                    time="{{ $donation->created_at->diffForHumans() }}" amin="-1">
                                    Berdonasi sebesar <strong>Rp. {{ number_format($donation->jumlah) }}</strong>
                                </x-media>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </x-slot>
    </x-card>
</x-layout>
