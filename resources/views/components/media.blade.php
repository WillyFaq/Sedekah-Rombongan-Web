@props(['name' => false, 'time' => false, 'amin' => false])
<div class="card-body">
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>{{ $name }}</strong></p>
            </div>
            <div class="col text-right">
                <small>{{ $time }}</small>
            </div>
        </div>
        <p>{{ $slot }}</p>
        @if ($amin >= 0)
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/imgs/praying-color3.png') }}" alt="Amin" style="width: 21px;">
                <p class="ml-2 mb-0">0 Amin</p>
            </div>
        @endif
    </div>
</div>
