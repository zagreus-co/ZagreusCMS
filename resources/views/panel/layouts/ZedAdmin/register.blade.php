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
                    <form action="" method="post">
                        @csrf
                        <div class="mb-3 space-y-1">
                            <label for="full_name">{{__('Full name')}}</label>
                            <input type="text" name="full_name" value='{{ old("full_name") }}' placeholder="{{ __('John doe') }}" class="form-control">
                        </div>
                        <div class="mb-3 space-y-1">
                            <label for="email">{{__('Email')}}</label>
                            <input type="email" name="email" value='{{ old("email") }}' placeholder="{{ __('Email like:') }} support@zagreus.company" class="form-control">
                        </div>
                        <div class='mb-3 space-y-1'>
                            <label for="number">{{ __("Phone number") }} <small>({{ __('optional') }})</small></label>
                            <input type="text" name="number" value='{{ old("number") }}' placeholder='{{ __("+44 1632 960429") }}' class="form-control text-left" style='direction:ltr'>
                        </div>
                        <div class="mb-3 space-y-1">
                            <label for="password">{{__('Password')}}</label>
                            <input type="password" name="password" placeholder="{{ __('Please enter your password here') }}" class="form-control">
                        </div>
                        <div class="mb-3 space-y-1">
                            <label for="password_confirmation">{{__('Password confirmation')}}</label>
                            <input type="password" name="password_confirmation" placeholder="{{ __('Please repeat your password') }}" class="form-control">
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('login') }}" class="theme-anchor">{{__('Already have an account?')}}</a>
                            <button class="btn btn-primary">{{__('Register')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </body>
</html>
