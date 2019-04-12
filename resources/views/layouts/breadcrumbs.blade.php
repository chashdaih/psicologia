<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        @foreach ($bread as $crumb)
        <li @if ($loop->last) class="is-active" @endif >
            <a @if ($crumb['url']) href="{{ route($crumb['url']['base'], $crumb['url']['par']) }}" @endif >
                {{ $crumb['title'] }}
            </a>
        </li>
        @endforeach
    </ul>
</nav>