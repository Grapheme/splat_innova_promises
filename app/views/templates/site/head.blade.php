<?
$fb_app_id = '1010986995584773';
$fb_friends_limit = 99;
?>
@section('title')
{{{ isset($page_title) ? $page_title : Config::get('app.default_page_title') }}}
@stop
@section('description')
{{{ isset($page_description) ? $page_description : Config::get('app.default_page_description') }}}
@stop
@section('keywords')
{{{ isset($page_keywords) ? $page_keywords : Config::get('app.default_page_keywords') }}}
@stop
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')">
        <meta name="viewport" content="width=device-width">

        <!-- Open Graph Meta Data -->
        <meta property="og:url" content="http://mypromises.ru">
        <meta property="og:title" content="Мои обещания">
        <meta property="og:description" content="Наши слова меняют мир, когда становятся делами.">
        <meta property="og:image" content="http://mypromises.ru/ogg_image.jpg">
        <meta property="og:site_name" content="mypromises.ru">
        <meta property="og:type" content="website">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory-->

        <link rel="shortcut icon" href="/favicon.ico">

        {{ HTML::stylemod(Config::get('site.theme_path') . '/styles/vendor.css') }}
        {{ HTML::stylemod(Config::get('site.theme_path') . '/styles/main.css') }}
        {{ HTML::scriptmod(Config::get('site.theme_path') . '/scripts/vendor/modernizr.js') }}

        <script>
        var base_url = '{{ URL::to('') }}';
        var domain = '<?=domain?>';
        </script>

        <script>
        var fb_app_id = {{ $fb_app_id  }};
        var fb_friends_limit = {{ $fb_friends_limit }};

        var user_id = {{ isset($auth_user) && is_object($auth_user) && $auth_user->id ? "'" . $auth_user->id . "'" : "''" }};
        </script>
