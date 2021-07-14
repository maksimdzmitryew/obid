@extends($theme . '::' . $_env->s_utype . '.master')

@section('title')
{{ mb_strtoupper($page->title) }}
@endsection

@section('content')

<div class="section_page">

	{!! $page->body !!}

  <div class="toc_content">
      <span class="toc_title">ЗМІСТ</span>
      @foreach ($pages AS $s_slug => $s_title)
      @if ($s_slug == $page_slug)
      <div class="toc_selected_wrapper">
        <span class="toc_selected_title">{{ $s_title }}</span>
      </div>
      @else
      <a href="{{ route('guest.page.posibnyk', ['page_slug' => $s_slug]) }}">
      	<div class="toc_item_wrapper">
	        <span class="toc_item_title">{{ $s_title }}</span>
	      </div>
      </a>
      @endif
      @endforeach
  </div>

  <div class="clear"></div>

@if ($page->file_uk && $attachments['file_uk'])
	<a href="{{ route('guest.file.download', ['file_id' => $attachments['file_uk']['id']]) }}" target="_blank">
  <div class="v21_34">
      <div class="v21_35">Завантажити 1 розділ укр</div>
      <div class="v21_36">
          <div>
              Завантажити українську версію
          </div>
          <div>
              <div class="download_text">
                  1 розділу посібника
              </div>
              <div class="download_ico">
                  <div class="ico_download_arrow">
                      <svg width="22" height="11" viewBox="0 0 22 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.045 0.860199C14.045 2.29716 12.8807 3.46101 11.4446 3.46101H9.67577C8.23969 3.46101 7.07539 2.29716 7.07539 0.860199H0.106201V8.26497C0.106201 9.22715 0.886315 10.0073 1.8485 10.0073H19.2715C20.2337 10.0073 21.0138 9.22715 21.0138 8.26497V0.860199H14.045Z" fill="#202020"/>
                      </svg>
                  </div>
                  <div class="ico_download_base">
                      <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M3.52355 11.55L6.8374 8.30409C7.16277 7.98481 7.0578 7.72608 6.60088 7.72608H4.61249V1.0962C4.61249 0.494671 4.12508 0.00726318 3.52355 0.00726318C2.92202 0.00726318 2.43461 0.494671 2.43461 1.0962V7.72608H0.446214C-0.0111389 7.72608 -0.116112 7.98525 0.210133 8.30409L3.52355 11.55Z" fill="#202020"/>
                      </svg>
                  </div>
              </div>
          </div>
      </div>
  </div>
	</a>
@endif

@if ($page->file_en && $attachments['file_en'])
	<a href="{{ route('guest.file.download', ['file_id' => $attachments['file_en']['id']]) }}" target="_blank">
  <div class="v21_34">
      <div class="v21_35">Завантажити 1 розділ en</div>
      <div class="v21_36">
          <div>
              Завантажити українську версію
          </div>
          <div>
              <div class="download_text">
                  1 розділу посібника
              </div>
              <div class="download_ico">
                  <div class="ico_download_arrow">
                      <svg width="22" height="11" viewBox="0 0 22 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14.045 0.860199C14.045 2.29716 12.8807 3.46101 11.4446 3.46101H9.67577C8.23969 3.46101 7.07539 2.29716 7.07539 0.860199H0.106201V8.26497C0.106201 9.22715 0.886315 10.0073 1.8485 10.0073H19.2715C20.2337 10.0073 21.0138 9.22715 21.0138 8.26497V0.860199H14.045Z" fill="#202020"/>
                      </svg>
                  </div>
                  <div class="ico_download_base">
                      <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M3.52355 11.55L6.8374 8.30409C7.16277 7.98481 7.0578 7.72608 6.60088 7.72608H4.61249V1.0962C4.61249 0.494671 4.12508 0.00726318 3.52355 0.00726318C2.92202 0.00726318 2.43461 0.494671 2.43461 1.0962V7.72608H0.446214C-0.0111389 7.72608 -0.116112 7.98525 0.210133 8.30409L3.52355 11.55Z" fill="#202020"/>
                      </svg>
                  </div>
              </div>
          </div>
      </div>
  </div>
	</a>
@endif

</div>

{{--
@ include($theme . '::' . $_env->s_utype . '._' . $page_slug)
--}}

@append

