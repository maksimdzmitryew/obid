<li class="nav-item">
    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="results-{{ $type }}-tab" data-toggle="tab" href="#results-{{ $type }}-text-tab" role="tab" aria-controls="results-{{ $type }}-text-tab" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ trans('search.' . $type) }} <span></span></a>
</li>
