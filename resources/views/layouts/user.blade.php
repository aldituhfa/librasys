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
                            <a href="{{ route('user.transactions') }}"
                                class="nav-link {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
                                <i class="ti ti-history"></i>
                                Peminjaman Saya
                            </a>
                        </li>

                    </ul>

                    <!-- RIGHT -->
                    <div class="d-flex align-items-center gap-3">

                        <div>
                            👤 {{ auth()->user()->name }}
                            <span class="badge bg-green-lt">User</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                Logout
                            </button>
                        </form>

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