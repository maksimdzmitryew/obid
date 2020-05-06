@if ($paginator->hasPages())
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item prev-page-item disabled">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"/>
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"/>
                    <path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z" fill="black"/>
                </svg>
            </li>
        @else
            <li class="page-item prev-page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"/>
                        <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(32) scale(-1 1)"/>
                        <path d="M0.435841 9.94886L9.9585 0.435333C10.5395 -0.145111 11.4818 -0.145111 12.0628 0.435333C12.6439 1.0159 12.6439 1.95702 12.0628 2.53758L5.08016 9.5135L30.5121 9.5135C31.3338 9.5135 32 10.1791 32 11C32 11.8208 31.3338 12.4865 30.5121 12.4865L5.08016 12.4865L12.0625 19.4624C12.6437 20.0429 12.6437 20.9841 12.0625 21.5646C11.7721 21.8547 11.3912 22 11.0104 22C10.6296 22 10.2488 21.8547 9.95826 21.5646L0.435841 12.0511C-0.145279 11.4705 -0.145279 10.5294 0.435841 9.94886Z" fill="black"/>
                    </svg>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item next-page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"/>
                        <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"/>
                        <path d="M31.5642 12.0511L22.0415 21.5647C21.4605 22.1451 20.5182 22.1451 19.9372 21.5647C19.3561 20.9841 19.3561 20.043 19.9372 19.4624L26.9198 12.4865H1.48792C0.666229 12.4865 0 11.8209 0 11C0 10.1792 0.666229 9.51353 1.48792 9.51353H26.9198L19.9375 2.53761C19.3563 1.95705 19.3563 1.01592 19.9375 0.435362C20.2279 0.145319 20.6088 0 20.9896 0C21.3704 0 21.7512 0.145319 22.0417 0.435362L31.5642 9.94889C32.1453 10.5295 32.1453 11.4706 31.5642 12.0511Z" fill="black"/>
                    </svg>
                </a>
            </li>
        @else
            <li class="page-item next-page-item">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"/>
                    <rect width="32" height="22" fill="black" fill-opacity="0" transform="translate(0 22) scale(1 -1)"/>
                    <path d="M31.5642 12.0511L22.0415 21.5647C21.4605 22.1451 20.5182 22.1451 19.9372 21.5647C19.3561 20.9841 19.3561 20.043 19.9372 19.4624L26.9198 12.4865H1.48792C0.666229 12.4865 0 11.8209 0 11C0 10.1792 0.666229 9.51353 1.48792 9.51353H26.9198L19.9375 2.53761C19.3563 1.95705 19.3563 1.01592 19.9375 0.435362C20.2279 0.145319 20.6088 0 20.9896 0C21.3704 0 21.7512 0.145319 22.0417 0.435362L31.5642 9.94889C32.1453 10.5295 32.1453 11.4706 31.5642 12.0511Z" fill="black"/>
                </svg>
            </li>
        @endif
    </ul>
@endif
