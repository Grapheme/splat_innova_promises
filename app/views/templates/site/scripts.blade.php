
    {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js") }}
    <script>window.jQuery || document.write('<script src="private/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>

    {{ HTML::script(Config::get('site.theme_path') . '/scripts/vendor.js') }}
    {{ HTML::script(Config::get('site.theme_path') . '/scripts/main.js') }}
    <script>SplatSite.index();</script>

    <link href="http://www.odnoklassniki.ru/oauth/resources.do?type=css" rel="stylesheet" />
    <script src="http://www.odnoklassniki.ru/oauth/resources.do?type=js" type="text/javascript" charset="utf-8"></script>

    {{ HTML::script("private/js/vendor/jquery.validate.min.js") }}
    {{ HTML::script("private/js/vendor/jquery-form.min.js") }}

    {{ HTML::scriptmod('js/app.js') }}

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter27511935 = new Ya.Metrika({id:27511935,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/27511935" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-17193616-17', 'auto');
      ga('require', 'linkid', 'linkid.js');
      ga('send', 'pageview');

    </script>
