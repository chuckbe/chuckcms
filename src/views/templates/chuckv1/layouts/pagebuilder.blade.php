<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<meta name="google-site-verification" content="bE0I5-3dkHpMW80FTgcR7LqL58lFi_Uzx9CQMK4qQHA" />-->
        
        <title>@yield('title')</title>
        
        @yield('meta')

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100,200,300,400,500,600,700,800,900" rel="stylesheet" type="text/css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Styles -->
        <link href="{{ asset('chuckbe/chuckcms/css/custom.css') }}" rel="stylesheet">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        @yield('css')

    </head>
    <body>
    <div class="body">
        
        <div class="container">
            @yield('content')
        </div>

    </div>
        <script src="{{ asset('chuckbe/chuckcms/js/app.js') }}"></script>

        <script type="text/javascript">
            var path = window.location.pathname.split('/');
            path = path[path.length-1];
            if (path !== undefined) {
              $("ul.navbar-nav")
                .find("a[href$='" + path + "']") // gets all links that match the href
                .parents('li')  // gets all list items that are ancestors of the link
                .addClass('active');
            }
            if (window.location =='http://www.chuck.be/' || window.location =='http://beta.chuck.be/'){
                $("ul.navbar-nav")
                .find('li').first() // get first list item
                .addClass('active');
            }

            (function($){
                $(document).ready(function(){
                    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
                        event.preventDefault(); 
                        event.stopPropagation(); 
                        $(this).parent().siblings().removeClass('open');
                        $(this).parent().toggleClass('open');
                    });
                });
            })(jQuery);
        </script>

        <script type="text/javascript">
            (function(document,navigator,standalone) {
                // prevents links from apps from oppening in mobile safari
                // this javascript must be the first script in your <head>
                if ((standalone in navigator) && navigator[standalone]) {
                    var curnode, location=document.location, stop=/^(a|html)$/i;
                    document.addEventListener('click', function(e) {
                        curnode=e.target;
                        while (!(stop).test(curnode.nodeName)) {
                            curnode=curnode.parentNode;
                        }
                        // Condidions to do this only on links to your own app
                        // if you want all links, use if('href' in curnode) instead.
                        if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) ) {
                            e.preventDefault();
                            location.href = curnode.href;
                        }
                    },false);
                }
            })(document,window.navigator,'standalone');
        </script>

        

        @yield('scripts')

        <!-- Global Site Tag (gtag.js) - Google Analytics -->
        <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-85594949-1"></script> -->
        <script>
          // window.dataLayer = window.dataLayer || [];
          // function gtag(){dataLayer.push(arguments)};
          // gtag('js', new Date());

          // gtag('config', 'UA-85594949-1');
        </script>

    </body>    

</html>