@props(['active' => false])
<li class="nav-item {{ $active ? 'active' : '' }} ">
    <a class="nav-link" {{ $attributes }} aria-current="{{ $active ? 'page' : false }}">
        {{ $slot }}
</li>
