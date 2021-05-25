<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    {!! SEO::Generate(true); !!}

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    {!! get_option(('head_extra')) !!}
    @livewireStyles
    <script src="{{ asset('js/turbolinks.js') }}"></script>
    <style>
        @font-face {
            font-family: "dana-regular";
            src: url("/fonts/dana-regular.woff") format("woff");
        }
        @font-face {
            font-family: "dana-bold";
            src: url("/fonts/dana-bold.woff") format("woff");
        }
        * {
            font-family: "dana-regular";
        }
    </style>
</head>