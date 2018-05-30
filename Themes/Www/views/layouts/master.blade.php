<!DOCTYPE html>
<html lang="en">
    <head>
        <base src="{{ URL::asset('/') }}" />
        <meta charset="utf-8">
        <title>
            {{ config('modules.core.core.site-name') }}
        </title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
        <script src="{{ mix('js/theme.js', 'themes/www') }}"></script>
        <link media="all" type="text/css" rel="stylesheet" href="{{ mix('css/theme.css', 'themes/www') }}">
        <script type="text/javascript">
            var siteName = "{{ config('modules.core.core.site-name') }}";
        </script>
        @routes
    </head>
    <body class="hold-transition">
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="{{ mix('js/app.js', 'themes/www') }}"></script>
    </body>
</html>
