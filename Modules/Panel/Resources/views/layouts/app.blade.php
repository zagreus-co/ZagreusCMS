<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEO::Generate(true); !!}

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/all.min.css') }}">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl-4-5.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom-style.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        .swal-text {
            text-align: right;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand bg-danger navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto">

            <li class="nav-item ml-2">
                <a href='{{ route("index") }}' target='_blank' class="nav-link bg-light text-danger" style="border-radius:4px;">
                    <font class="text-dark">مشاهده سایت</font>
                    <!-- <i class="fa fa-sign-out-alt text-dark"></i> -->
                </a>
            </li>

            <li class="nav-item dropdown ml-2">
                <a class="nav-link bg-light text-danger" data-toggle="dropdown" href="#" style="border-radius:4px;">
                    <i class="fa fa-bell text-dark"></i>
                <span class="badge badge-warning navbar-badge" id='notification_count'>{{ \Notifications::query()->whereUserId(auth()->user()->id)->whereVisible(1)->whereSeen(0)->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left text-dark">
                    <div id="notification_container">
                        @foreach (\Notifications::query()->whereUserId(auth()->user()->id)->whereVisible(1)->latest()->limit(4)->get() as $notification)
                        <a href="javascript:void(0)" onclick='seenNotification(this, {{ $notification->id}} )' class="dropdown-item">
                            <div class="media">
                                <div class="media-body text-dark">
                                    <h3 class="dropdown-item-title @if (!$notification->seen) text-danger @endif">
                                        {{ $notification->title }}
                                        <span class="float-left text-sm text-seconadry"><i class="fa fa-eye"></i></span>
                                    </h3>
                                    <p class="text-sm mt-2">
                                        {{ mb_substr($notification->message, 0, 35) }}[...]
                                    </p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> {{ jdate($notification->created_at)->ago() }} </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-footer">
                        <a href="{{ route('module.notification.index') }}" class="btn btn-block btn-secondary">مشاهده همه پیام‌ها</a>
                    </div>
                </div>
            </li>

            <li class="nav-item ml-2">
                <a onclick="logOut();" href='javascript:void(0)' class="nav-link bg-light text-danger" style="border-radius:4px;">
                    <i class="fa fa-sign-out-alt text-dark"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-danger elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('index') }}" target='_blank' class="brand-link text-center bg-danger">
            <span class="brand-text font-weight-light">{{ \Option::get('site_short_name')->data }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <div>
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info d-flex">
                <a href="{{ route('module.users.profile') }}" class="d-block">
                    <label>{{ auth()->user()->full_name }}</label>
                    <i class="fa fa-check-circle text-info"></i>
                </a>
                
            </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('panel::layouts.sidebar')
            </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $title }}</h1>
            </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        @yield('breadcrumb')
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script>let base_url = "{{  route('index') }}"; let logOut_url = "{{  route('module.users.logout') }}";</script>
    <script src="{{ asset('assets/js/panel.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @include('panel::layouts.modal_error')
    @include("sweet::alert")

    <script>
        let seenNotification = (self, id) => {
            let notification = $( $(self).children()[0] ).children()[0];
            
            $.ajax({
                type: 'POST',
                url: "{{route('module.notification.seen', ':val:')}}".replace(':val:', id),
                // data: JSON.stringify(),
                dataType: 'json',
                success: function (data) {
                    if (data.result) {
                        $($(notification).children()[0]).removeClass('text-danger')
                        $("#notification_count").html( parseInt($("#notification_count").text()) - 1 )
                    }
                    swal({
                        text: data.message,
                        html: true,
                        className: "text-center",
                    })
                },
                error: function (data) {
                    swal(data.responseJSON.message);
                }
            });
        }

        let loadNotifications = () => {
            $.ajax({
                type: 'POST',
                url: "{{ route('module.notification.load') }}",
                dataType: 'json',
                success: function (data) {
                    let notSeenCount = 0;
                    $("#notification_container").html('');
                    for (i in data) {
                        notSeenCount += data[i]['seen'] ? 0 : 1;
                        $("#notification_container").append(`
                        <a href="javascript:void(0)" onclick='seenNotification(this, ${data[i]['id']} )' class="dropdown-item">
                            <div class="media">
                                <div class="media-body text-dark">
                                    <h3 class="dropdown-item-title ` + (data[i]['seen'] ? "" : 'text-danger') + `">
                                        ${data[i]['title']}
                                        <span class="float-left text-sm text-seconadry"><i class="fa fa-eye"></i></span>
                                    </h3>
                                    <p class="text-sm mt-2">
                                        ${data[i]['message']}
                                    </p>
                                    <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> ${data[i]['time']} </p>
                                </div>
                            </div>
                        </a>
                        `);
                    }
                    $("#notification_count").html( notSeenCount );
                }
            });
        }

        setInterval(() => {
            loadNotifications();
        }, 60000);
    </script>
    @yield('script')
</body>
</html>