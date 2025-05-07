<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('editor_home') }}">Editor Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('posts.index') }}"></a>
        </div>

        <ul class="sidebar-menu">
            {{-- <li class="{{ Request::is('editor/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('editor_home') }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li> --}}

            <li class="{{ Request::is('editor/posts*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('posts.index') }}">
                    <i class="fas fa-newspaper"></i> <span>Posts</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
