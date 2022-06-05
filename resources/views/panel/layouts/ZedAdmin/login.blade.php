<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="theme-color" content="#5c68ff" />
        {!! SEO::Generate() !!}
        <link rel="stylesheet" href="{{panelAsset('css/app.css')}}" />
    </head>
    <body dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">

        <section class="flex justify-center" style="height: 100vh;">
            <div class="card w-11/12 md:w-9/12 lg:w-5/12 my-auto mx-auto">
                <div class="card-header justify-between border-b border-gray-100 py-3 mb-3">
                    <h1 class="text-3xl">ZedAdmin<span class="text-theme-primary">.</span></h1>
                    <a href="{{ route('index') }}" class="theme-anchor">{{__('Back to home')}}</a>
                </div>
                <div class="card-body">
                    @panelView('errors-alert')
                    @if (session('reset-password'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('reset-password') }}
                        </div>
                    @endif
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3 space-y-1">
                            <label for="email">{{__('Email')}}: </label>
                            <input type="text" name="email" placeholder="{{ __('Email like:') }} support@zagreus.company" class="form-control">
                        </div>
                        <div class="mb-3 space-y-1">
                            <label for="password">{{__('Password')}}: </label>
                            <input type="password" name="password" placeholder="{{ __('Please enter your password here') }}" class="form-control">
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label" for="remember">
                                    {{__('Remember me')}}
                                </label>
                            </div>
                            <button class="btn btn-primary">{{__('Login')}}</button>
                        </div>
                    </form>
                    <div class="flex justify-between border-t border-gray-100 mt-4 pt-2">
                        @if (get_option('allow_register'))
                        <a href="{{ route('register') }}" class="theme-anchor">{{__('Create new account')}}</a>
                        @endif
                        <a href="{{ route('password.request.email') }}" class="theme-anchor">{{__('Forget password')}}</a>
                    </div>
                </div>
            </div>
        </section>

    </body>
</html>
