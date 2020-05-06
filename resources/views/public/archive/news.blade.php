@extends('layouts.public')

@section('script')
<script type="text/javascript">
    $(document).on('ready', () => {
        let tpl = $('#news-tpl').html();



    });
</script>
@endsection

@section('content')
<div class="content news-list-page">
    <div class="container-fluid">
        <h1 class="block-title">{{ trans('general.news') }}</h1>
    </div>
    <div class="filter-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl col-sm-3 col-6">
                    <div class="filter-label selected">{{ trans('general.all') }}<i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
                @foreach($categories as $category)
                    <div class="col-xl col-sm-3 col-6 filter">
                        <div class="filter-label">{{ $category->name }} <i class="fa fa-times" aria-hidden="true"></i></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="news-block">
        <div class="container-fluid">
            <div class="row">
                @foreach($news as $post)
                    @include('public.partials.post')
                @endforeach
            </div>

            <nav aria-label="Page navigation example">
                {{ $news->links() }}
            </nav>

        </div>
    </div>
</div>

<div id="post-tpl" class="d-none">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="news-item">
            <div class="img-wrap">
                <div class="label">${category.name}</div>
                <a href="${url}"><img src="${image.url}" alt=""></a>
            </div>
            <div class="descr">
                <div class="date">${date}</div>
                <h4 class="news-title"><a href="${url}">${title}</a></h4>
                <div class="short">${excerpt}</div>
            </div>
        </div>
    </div>
</div>

@endsection
