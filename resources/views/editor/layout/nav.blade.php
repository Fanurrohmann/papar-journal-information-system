@php
    $editor = Auth::guard('editor')->user();
@endphp

<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right w-100-p justify-content-end">
        <li class="nav-link">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-warning">Front End</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset($editor->photo ? 'uploads/editor/' . $editor->photo : 'uploads/default.png') }}"
                     alt="profile" class="rounded-circle" style="width: 20px; height: 20px; object-fit: cover;">
                <div class="d-sm-none d-lg-inline-block">{{ $editor->name }}</div>
            </a>

            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="far fa-user"></i> Edit Profile
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
