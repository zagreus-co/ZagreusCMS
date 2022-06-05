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
                    @if (session('status'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="" method="post">
                        @csrf
                        <div class="mb-3 space-y-1">
                            <label for="email">{{__('Email address')}}: </label>
                            <input type="email" name="email" placeholder="{{ __('Email like:') }} support@zagreus.company" class="form-control">
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('login') }}" class="theme-anchor">{{__('Already have an account?')}}</a>
                            <button class="btn btn-primary">{{__('Submit reset request')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </body>
</html>
