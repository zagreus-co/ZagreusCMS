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
                <!-- <a href='{{ route("index") }}'><img src="{{ asset('img/ZagreusDevs-logo.png') }}" width='200px' alt="Zapegreus Develors"></a> -->
                <h1 class="text-3xl font-light text-gray-700">{{ __('Register new account') }}</h1>
            </div>

            <div class="mt-5">
                @panelView('errors-alert')
                <form action="" method="post">
                    @csrf
                    <div>
                        <label class="text-gray-700 dark:text-gray-200" for="full_name">{{ __("Full name") }}</label>
                        <input id="full_name" name="full_name" type="text" value='{{ old("full_name") }}' placeholder='{{ __("John doe") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    
                    <div class='mt-5'>
                        <label class="text-gray-700 dark:text-gray-200" for="username">{{ __("Email address") }}</label>
                        <input id="username" name="username" type="text" value='{{ old("username") }}' placeholder='{{ __("Email address") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div class='mt-5'>
                        <label class="text-gray-700 dark:text-gray-200" for="number">{{ __("Phone number") }} <small>({{ __('optional') }})</small></label>
                        <input id="number" name="number" type="text" value='{{ old("number") }}' placeholder='{{ __("+44 1632 960429") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div class='mt-5'>
                        <label class="text-gray-700 dark:text-gray-200" for="password">{{ __("Password") }}</label>
                        <input id="password" name="password" type="password" placeholder='{{ __("Account password") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>

                    <div class='mt-5'>
                        <label class="text-gray-700 dark:text-gray-200" for="password_confirmation">{{ __("Password confirmation") }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder='{{ __("Please repeat your password") }}' class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    
                    <button type="submit" class='hidden'>Register trigger</button>
                </form>
            </div>
            
            <div class="flex flex-wrap mt-4">
                <button onclick='document.querySelector("form").submit()' class="w-full px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-teal-400 rounded-md hover:bg-teal-500 focus:outline-none focus:bg-teal-600">{{__('Register')}}</button>
                
            </div>
            <div class="flex justify-between mt-3">
                <a href="{{ route('index') }}" class="">{{__('Back to home')}}</a>
                <a href="{{ route('login') }}" class="">{{__('Login')}}</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
