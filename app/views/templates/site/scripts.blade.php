
    {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js") }}
    <script>window.jQuery || document.write('<script src="private/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>

    {{ HTML::script(Config::get('site.theme_path') . '/scripts/vendor.js') }}
    {{ HTML::script(Config::get('site.theme_path') . '/scripts/main.js') }}

    <script src="http://www.odnoklassniki.ru/oauth/resources.do?type=js" type="text/javascript" charset="utf-8"></script>

    {{ HTML::scriptmod('js/app.js') }}
