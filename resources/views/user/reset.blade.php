<x-layout>
    <x-slot:page_title>{{ $page_title }}</x-slot:page_title>
    <x-pageheading>Pengguna</x-pageheading>
    <x-card title="{{ $page_title }}">
        <x-slot name="body">
            {{-- @if ($errors->count())
                {{ dd(request()) }}
            @endif --}}
            {{-- {{ dump(old('password')) }}
            {{ dump(old('repassword')) }} --}}
            <form method="post" action="/user/{{ $user->id }}">
                @method('put')
                @csrf
                <input type="hidden" name="type" value="reset">
                <div class="form-group">
                    <label for="newpassword">New Password</label>
                    <input type="text" class="form-control @error('newpassword') is-invalid @enderror"
                        id="newpassword" name="newpassword" required value="{{ old('newpassword') }}">
                    @error('newpassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="repassword">Re-type Password</label>
                    <input type="text" class="form-control @error('repassword') is-invalid @enderror" id="repassword"
                        name="repassword" required value="{{ old('repassword') }}">
                    @error('repassword')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </x-slot>
    </x-card>
</x-layout>
