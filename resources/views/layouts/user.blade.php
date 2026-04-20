<!doctype html>
<html>

<head>
    <title>User - LibraSys</title>

    <!-- TABLER -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body {
            background: #f5f7fb;
        }

        /* NAVBAR */

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            height: 60px;
        }

        /* BRAND */

        .navbar-brand {
            font-weight: 700;
            font-size: 18px;
        }

        /* MENU */

        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            color: #374151;
            padding: 8px 14px;
            border-radius: 6px;
            transition: .2s;
        }

        /* HOVER */

        .navbar-nav .nav-link:hover {
            background: #f1f5f9;
        }

        /* ACTIVE */

        .navbar-nav .active {
            background: #e5e7eb;
            color: #000 !important;
        }

        /* ICON */

        .navbar-nav i {
            font-size: 18px;
        }

        /* CONTENT */

        .content {
            padding: 20px;
        }

        .navbar-nav {
            margin-left: 40px;
        }
    </style>

</head>

<body>

    <div class="page">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg topbar">

            <div class="container-fluid">

                <!-- BRAND -->
                <a class="navbar-brand" href="#">
                    LibraSys
                </a>

                <!-- TOGGLE MOBILE -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- MENU -->
                <div class="collapse navbar-collapse" id="navbarMenu">

                    <!-- LEFT MENU -->
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item">
                            <a href="{{ route('user.books') }}"
                                class="nav-link {{ request()->routeIs('user.books') ? 'active' : '' }}">
                                <i class="ti ti-book"></i>
                                Beranda
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.favorites') }}"
                                class="nav-link {{ request()->routeIs('user.favorites') ? 'active' : '' }}">
                                <i class="ti ti-heart"></i>
                                Favorit
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.transactions') }}"
                                class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs('user.transactions') ? 'active' : '' }}">

                                <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-history"></i>
                                    <span>Peminjaman Saya</span>
                                </div>

                                {{-- NOTIF --}}
                                @if($approvedCount > 0)
                                <span class="badge rounded-pill"
                                    style="background:#22c55e; color:white; font-size:10px;">
                                    {{ $approvedCount }}
                                </span>
                                @endif

                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.report') }}"
                                class="nav-link {{ request()->routeIs('user.report') ? 'active' : '' }}">
                                <i class="ti ti-file-report"></i>
                                Riwayat Peminjaman
                            </a>
                        </li>

                    </ul>

                    <!-- RIGHT -->
                    <div class="d-flex align-items-center gap-3">

                        <div class="dropdown">

                            <button class="btn d-flex align-items-center gap-2 border-0"
                                data-bs-toggle="dropdown"
                                style="background: transparent;">

                                {{-- NAME --}}
                                <div class="text-start d-none d-md-block">
                                    <div class="small fw-semibold">{{ auth()->user()->name }}</div>
                                    <div class="text-muted small">User</div>
                                </div>

                                <i class="ti ti-chevron-down small text-muted"></i>
                            </button>

                            {{-- DROPDOWN --}}
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2">

                                <li>
                                    <div class="dropdown-item-text">
                                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                    </div>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item text-danger rounded-2">
                                            <i class="ti ti-logout me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>
        </nav>


        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

    </div>


    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#categoryTable').DataTable();
            $('#bookTable').DataTable();
        })
    </script>

</body>

</html>