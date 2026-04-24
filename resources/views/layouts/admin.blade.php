<!doctype html>
<html>

<head>
    <title>Admin - LibraSys</title>

    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        /* Warna background utama - biru sangat lembut (hint of blue) */
        body {
            background: #eef2f7;
            /* biru keabu-abuan sangat soft */
        }

        /* SIDEBAR - PUTIH */
        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: .25s;
            z-index: 1000;
            background: #ffffff;
            /* putih */
            border-right: 1px solid #e5e7eb;
            /* border halus */
        }

        /* COLLAPSE SIDEBAR */
        .sidebar.collapsed {
            width: 80px;
        }

        /* LOGO */
        .logo {
            padding: 22px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            /* gelap untuk kontras di putih */
        }

        /* MENU */
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .sidebar ul li {
            position: relative;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            margin: 4px 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
            transition: .2s;
            color: #374151;
            /* teks gelap */
        }

        /* ICON */
        .sidebar i {
            font-size: 20px;
        }

        /* HOVER MENU */
        .sidebar ul li a:hover {
            background: #f3f4f6;
            /* abu-abu sangat muda */
        }

        /* ACTIVE MENU */
        .sidebar .active {
            background: #e5e9f0;
            /* abu kebiruan tipis */
            color: #1e40af;
        }

        /* HIDE TEXT KETIKA COLLAPSE */
        .sidebar.collapsed .menu-text {
            display: none;
        }

        /* TOOLTIP SAAT COLLAPSE */
        .sidebar.collapsed li:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 78px;
            top: 50%;
            transform: translateY(-50%);
            background: #111827;
            color: #fff;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 1100;
        }

        /* PAGE WRAPPER */
        .page-wrapper {
            margin-left: 230px;
            transition: .25s;
        }

        .page-wrapper.collapsed {
            margin-left: 80px;
        }

        /* HEADER - PUTIH */
        .header {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            background: #ffffff;
            /* putih */
            border-bottom: 1px solid #e2e8f0;
            /* border soft */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        /* TOMBOL TOGGLE (BUKA TUTUP SIDEBAR) */
        .toggle-btn {
            cursor: pointer;
            font-size: 22px;
            color: #334155;
            transition: .2s;
        }

        .toggle-btn:hover {
            color: #0f172a;
        }

        /* KONTEN UTAMA - background biru sangat lembut sudah di body */
        .p-4 {
            background: transparent;
            /* biar ikut body */
        }

        /* Card atau komponen lain tetap rapi */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .menu-title {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            color: #94a3b8;
            margin: 16px 12px 6px;
            letter-spacing: 0.5px;
        }
    </style>

</head>

<body>

    <div class="page">

        <!-- SIDEBAR (PUTIH) -->
        <aside id="sidebar" class="sidebar">

            <div class="logo">
                <span class="menu-text">LibraSys</span>
            </div>

            <ul>

                {{-- DASHBOARD --}}
                <li data-title="Dashboard">
                    <a href="{{ route('admin.DashboardAdmin') }}"
                        class="{{ request()->routeIs('admin.DashboardAdmin') ? 'active' : '' }}">
                        <i class="ti ti-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                {{-- MASTER DATA --}}
                <li class="menu-title">Master Data</li>

                <li data-title="Kategori">
                    <a href="{{ route('admin.categories') }}"
                        class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                        <i class="ti ti-category"></i>
                        <span class="menu-text">Category</span>
                    </a>
                </li>

                <li data-title="Genre">
                    <a href="{{ route('admin.genres') }}"
                        class="{{ request()->routeIs('admin.genres') ? 'active' : '' }}">
                        <i class="ti ti-tags"></i>
                        <span class="menu-text">Genre</span>
                    </a>
                </li>

                <li data-title="Buku">
                    <a href="{{ route('admin.books') }}"
                        class="{{ request()->routeIs('admin.books') ? 'active' : '' }}">
                        <i class="ti ti-book"></i>
                        <span class="menu-text">Book</span>
                    </a>
                </li>

                <li data-title="User">
                    <a href="{{ route('admin.users') }}"
                        class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="ti ti-users"></i>
                        <span class="menu-text">User</span>
                    </a>
                </li>

                {{-- TRANSACTION --}}
                <li class="menu-title">Transaction</li>

                <li data-title="Peminjaman">
                    <a href="{{ route('admin.transactions') }}"
                        class="d-flex justify-content-between align-items-center {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">

                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-clipboard-text"></i>
                            <span class="menu-text">Transaction</span>
                        </div>

                        @if($pendingCount > 0)
                        <span class="badge rounded-pill"
                            style="background:#ef4444; color:white; font-size:10px;">
                            {{ $pendingCount }}
                        </span>
                        @endif

                    </a>
                </li>

                <li data-title="Report">
                    <a href="{{ route('admin.report') }}"
                        class="{{ request()->routeIs('admin.report') ? 'active' : '' }}">
                        <i class="ti ti-file-report"></i>
                        <span class="menu-text">Report</span>
                    </a>
                </li>

            </ul>

        </aside>


        <!-- PAGE WRAPPER -->
        <div id="pageWrapper" class="page-wrapper">

            <div class="header">

                <div class="d-flex align-items-center gap-3">
                    <!-- HANYA TOMBOL BUKA TUTUP SIDEBAR (tanpa mode toggle) -->
                    <i id="toggleSidebar" class="ti ti-menu-2 toggle-btn"></i>
                </div>

                <div class="dropdown">

                    <button class="btn d-flex align-items-center gap-2 border-0"
                        data-bs-toggle="dropdown"
                        style="background: transparent;">

                        {{-- NAME --}}
                        <div class="text-start d-none d-md-block">
                            <div class="small fw-semibold">{{ auth()->user()->name }}</div>
                            <div class="text-muted small">Admin</div>
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
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>


    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- TABLER -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    <!-- DATATABLES (BOOTSTRAP 5 STYLE) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        // SIDEBAR
        const sidebar = document.getElementById("sidebar")
        const pageWrapper = document.getElementById("pageWrapper")
        const toggleSidebar = document.getElementById("toggleSidebar")

        toggleSidebar.onclick = function() {
            sidebar.classList.toggle("collapsed")
            pageWrapper.classList.toggle("collapsed")
        }

        // GLOBAL DATATABLE
        $(document).ready(function() {

            $('.datatable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],

                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data...",
                    lengthMenu: "Tampilkan _MENU_",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_",
                    zeroRecords: "Data tidak ditemukan",
                },

                dom: "<'row mb-3'<'col-md-6'l><'col-md-6'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-md-5'i><'col-md-7'p>>",

                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            });

        });
    </script>

    <!-- WAJIB -->
    @stack('scripts')

    <style>
        .dataTables_filter input {
            border-radius: 8px;
            padding: 6px 12px;
        }

        .dataTables_length select {
            border-radius: 8px;
        }

        .dataTables_paginate .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
        }
    </style>
</body>

</html>