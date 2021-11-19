<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
    <link rel="stylesheet" type="text/css" href="{{panelAsset('css/style.css')}}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    {!! SEO::Generate() !!}
</head>
<body class="bg-gray-100">
    
<div class="flex h-screen">
    <div class="m-auto">
        <div class="w-96 px-8 py-4 mx-auto bg-white rounded-lg shadow-md mt-5">
            <div class="flex flex-wrap items-center justify-center">
                <a href='{{ route("index") }}'><img src="{{ asset('img/ZagreusDevs-logo.png') }}" width='200px' alt="Zapegreus Develors"></a>
                <h1 class="text-3xl font-light text-gray-700 mt-3">{{ __('Login to account') }}</h1>
            </div>

            <div class="mt-5">
                @panelView('errors-alert')
                @if (session('reset-password'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('reset-password') }}
                    </div>
                @endif
                <form action="" method="post">
                    @csrf
                    <div>
                        <label class="text-gray-700 dark:text-gray-200" for="email">{{ __("Email") }}</label>
                        <input id="email" name="email" type="text" placeholder='{{ __("Email address") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div class='mt-5'>
                        <label class="text-gray-700 dark:text-gray-200" for="password">{{ __("Password") }}</label>
                        <input id="password" name="password" type="password" placeholder='{{ __("Account password") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div class='mt-5'>
                        <input type="checkbox" id="remember" name="remember" value="Bike">
                        <label for="remember"> {{__('Remember me')}}</label>
                    </div>

                    <button type="submit" class='hidden'>Login trigger</button>
                </form>
            </div>
            
            <div class="flex flex-wrap mt-4">
                <button onclick='document.querySelector("form").submit()' class="w-full px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-teal-400 rounded-md hover:bg-teal-500 focus:outline-none focus:bg-teal-600">{{__('Login')}}</button>
                
            </div>
            <div class="flex justify-between mt-3">
                <a href="{{ route('password.request.email') }}" class="">{{__('Forget password')}}</a>
                
                @if (get_option('allow_register'))
                <a href="{{ route('register') }}" class="">{{__('Register')}}</a>
                @endif
            </div>

        </div>
    </div>
</div>

</body>
</html>
