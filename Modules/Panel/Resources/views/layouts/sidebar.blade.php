<li class="nav-item">
    <a href="{{ route('module.panel.index') }}" class="nav-link {{ isActive('module.panel.index') }}">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p> پیشخوان </p>
    </a>
</li>

@include("blog::sidebar")
@include("comment::sidebar")
@include("user::sidebar")
@include("football::sidebar")
@include("poll::sidebar")
@include("gallery::sidebar")
@include("advertisement::sidebar")
@include("page::sidebar")
@include("notification::sidebar")
@include("media::sidebar")
@include("option::sidebar")

<?php /* @foreach ( Module::allEnabled() as $name => $module )
    @if (view()->exists( $module->getLowerName()."::sidebar" ))
        @include( $module->getLowerName()."::sidebar" )
    @endif
@endforeach */ ?>