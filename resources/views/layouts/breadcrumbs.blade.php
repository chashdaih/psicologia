<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        @foreach ($bread as $slice)
        <li @if ($loop->last) class="is-active" @endif >
            <a @if ($slice['url']) href="{{ route($slice['url']['base'], $slice['url']['par']) }}" @else href="#" @endif >
                {{ $slice['title'] }}
            </a>
        </li>
        @endforeach
    </ul>
</nav>