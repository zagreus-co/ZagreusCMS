<div id="sideBar" class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">
    <!-- sidebar content -->
    <div class="flex flex-col">

    <!-- sidebar toggle -->
        <div class="text-right hidden md:block mb-4">
            <button id="sideBarHideBtn">
                <i class="fad fa-times-circle text-xl"></i>
            </button>
        </div>
        <!-- end sidebar toggle -->

        <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Client sidebar</p>

        <a href="{{ route('module.panel.index') }}" class="mb-3 capitalize font-medium text-md {{ isActive('module.panel.index', 'text-teal-600', 'hover:text-teal-600') }} transition ease-in-out duration-200">
            <i class="fad fa-tachometer-alt text-xs mr-2"></i>                
            {{ __('Dashboard') }}
        </a>

        @foreach ( Module::getOrdered() as $name => $module )
            @if (view()->exists( $module->getLowerName()."::sidebar" ))
                @include( $module->getLowerName()."::sidebar" )
            @endif
        @endforeach
    </div>
    <!-- end sidebar content -->
</div>