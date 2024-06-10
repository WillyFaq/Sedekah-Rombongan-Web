@props(['jumlah' => false, 'total' => false])
@php
    $jml = (int) $jumlah;
    $tot = (int) $total;
    $percent = ceil(($jml / $tot) * 100);
    $bg = 'bg-primary';
    if ($percent <= 25) {
        $bg = 'bg-danger';
    } elseif ($percent <= 60) {
        $bg = 'bg-warning';
    } elseif ($percent <= 80) {
        $bg = 'bg-primary';
    } else {
        $bg = 'bg-success';
    }
@endphp
<div class="progress">
    <div class="progress-bar {{ $bg }}" role="progressbar" style="width: {{ $percent }}%;"
        aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
        {{ $percent }}%
    </div>
</div>
