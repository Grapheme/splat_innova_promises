@if (@is_object($page->meta->seo))
@section('title'){{ $page->meta->seo->title ? $page->meta->seo->title : $page->name }}@stop
@section('description'){{ $page->meta->seo->description }}@stop
@section('keywords'){{ $page->meta->seo->keywords }}@stop
@elseif (@is_object($page->meta))
@section('title')
{{{ $page->name }}}@stop
@elseif (@is_object($seo))
@section('title'){{ $seo->title }}@stop
@section('description'){{ $seo->description }}@stop
@section('keywords'){{ $seo->keywords }}@stop
@endif
<?
define('domain', 'http://' . $_SERVER['HTTP_HOST']);
?><!DOCTYPE html>
    <head>
	@include(Helper::layout('head'))

    @section('style')
        <!-- section style -->
    @show
    </head>
<body class="index-page">
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    @include(Helper::layout('header'))

    <div class="content-wrapper">
        @section('content')
            {{ @$content }}
        @show
    </div>

    @include(Helper::layout('footer'))
    @include(Helper::layout('scripts'))

    @section('overlays')
    @show

    @section('scripts')
    @show
</body>