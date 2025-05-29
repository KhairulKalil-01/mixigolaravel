<!-- sidebar start-->
<aside class="codex-sidebar">
    <div class="logo-gridwrap"><a class="codexbrand-logo" href="index.html"><img class="img-fluid"
                src="../assets/images/logo/logo.png" alt="theeme-logo"></a><a class="codex-darklogo" href="index.html"><img
                class="img-fluid" src="../assets/images/logo/dark-logo.png" alt="theeme-logo"></a>
        <div class="sidebar-action"><i data-feather="menu"></i></div>
    </div>
    <div class="icon-logo"><a href="index.html"><img class="img-fluid" src="../assets/images/logo/icon-logo.png"
                alt="theeme-logo"></a></div>


    {{-- dfasdfdasf --}}
    <div class="codex-menuwrapper">
        <ul class="codex-menu custom-scroll" data-simplebar>
            {{-- $permissionsByModule is from view composer, app/Providers/ViewServiceProvider--}}
            @foreach ($permissionsByModule as $moduleName => $permissions)
                <li class="cdxmenu-title">
                    <h5>{{ $moduleName }}</h5>
                </li>

                @foreach ($permissions as $permission)
                    @if ($permission->visible_in_menu)
                        <li class="menu-item"><a href="{{ route($permission->slug) }}">
                                <div class="icon-item"></div><span> {{ $permission->name }}</span>
                            </a></li>
                        </li>
                    @endif
                @endforeach
            @endforeach

        </ul>
    </div>

</aside>
<!-- sidebar end-->
