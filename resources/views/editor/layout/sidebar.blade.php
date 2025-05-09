<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('editor_home') }}">Editor Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('posts.index') }}"></a>
        </div>

        <ul class="sidebar-menu">
            <li class="{{ Request::is('editor/home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('editor_home') }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>

            <li class="{{ Request::is('editor/posts*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('posts.index') }}">
                    <i class="fas fa-newspaper"></i> <span>Manajemen Berita</span>
                </a>
            </li>

            <li class="nav-item dropdown {{ Request::is('editor/top-advertisement')||Request::is('editor/home-advertisement')||Request::is('editor/sidebar-advertisement-*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-ad"></i><span>Advertisements</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('editor/top-advertisement') ? 'active' : '' }}"><a class="nav-link" href="{{ route('editor_top_ad_show') }}"><i class="fas fa-angle-right"></i> Top Advertisements</a></li>
                    <li class="{{ Request::is('editor/home-advertisement') ? 'active' : '' }}"><a class="nav-link" href="{{ route('editor_home_ad_show') }}"><i class="fas fa-angle-right"></i> Home Advertisements</a></li>
                    <li class="{{ Request::is('editor/sidebar-advertisement-*') ? 'active' : '' }}"><a class="nav-link" href="{{ route('editor_sidebar_ad_show') }}"><i class="fas fa-angle-right"></i> Sidebar Advertisements</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
