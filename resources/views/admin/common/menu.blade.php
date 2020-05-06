 <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">{!! trans('menu.menu') !!}</div> <i class="icon-menu" title="Main"></i></li>

@php
include(base_path().'/resources/views/user/menu.php');
@endphp
@include('admin.common._menu_group')

                <!-- /main -->
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->