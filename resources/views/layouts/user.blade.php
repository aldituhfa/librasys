<!doctype html>
<html>

<head>
    <title>User - LibraSys</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
</head>

<body>

    <div class="page">

        <!-- SIDEBAR -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <h1 class="navbar-brand">User</h1>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('user.DashboardUser') }}" class="nav-link">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.books') }}" class="nav-link">
                            Daftar Buku
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('user.transactions') }}" class="nav-link">
                            Riwayat Peminjaman
                        </a>
                    </li>

                </ul>
            </div>
        </aside>


        <!-- PAGE WRAPPER -->
        <div class="page-wrapper">

            <!-- HEADER -->
            <div class="navbar navbar-light bg-white shadow-sm px-4">
                <div class="container-fluid d-flex justify-content-end align-items-center">

                    <div class="me-3">
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

            <!-- CONTENT -->
            <div class="p-4">
                @yield('content')
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>