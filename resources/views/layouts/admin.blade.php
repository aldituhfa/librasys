<!doctype html>
<html>

<head>
    <title>Admin - LibraSys</title>

    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body {
            background: #f5f7fb;
        }

        /* SIDEBAR */

        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: .25s;
            z-index: 1000;
        }

        /* DARK SIDEBAR */

        .sidebar.dark {
            background: #061726;
            /* lebih gelap */
        }

        /* LIGHT SIDEBAR */

        .sidebar.light {
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
        }

        /* COLLAPSE */

        .sidebar.collapsed {
            width: 80px;
        }

        /* LOGO */

        .logo {
            padding: 22px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            color: white;
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
        }

        /* ICON */

        .sidebar i {
            font-size: 20px;
        }

        /* DARK MENU */

        .sidebar.dark a {
            color: #ffffff;
        }

        .sidebar.dark a:hover {
            background: #173d60;
        }

        /* ACTIVE MENU */

        .sidebar.dark .active {
            background: #cecece;
            color: #000;
        }

        /* LIGHT MODE */

        .sidebar.light a {
            color: #374151;
        }

        .sidebar.light a:hover {
            background: #ffffff;
        }

        .sidebar.light .active {
            background: #fafbfb;
        }

        /* HIDE TEXT */

        .sidebar.collapsed .menu-text {
            display: none;
        }

        /* TOOLTIP */

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
        }

        /* PAGE WRAPPER */

        .page-wrapper {
            margin-left: 230px;
            transition: .25s;
        }

        .page-wrapper.collapsed {
            margin-left: 80px;
        }

        /* HEADER */

        .header {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            background: white;
            border-bottom: 1px solid #eee;
        }

        /* BUTTON */

        .toggle-btn {
            cursor: pointer;
            font-size: 22px;
        }

        .mode-btn {
            cursor: pointer;
            font-size: 20px;
        }
    </style>

</head>

<body>

    <div class="page">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="sidebar dark">

            <div class="logo">
                <span class="menu-text">LibraSys</span>
            </div>

            <ul>

                <li data-title="Dashboard">
                    <a href="{{ route('admin.DashboardAdmin') }}"
                        class="{{ request()->routeIs('admin.DashboardAdmin') ? 'active' : '' }}">
                        <i class="ti ti-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li data-title="Kategori">
                    <a href="{{ route('admin.categories') }}"
                        class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                        <i class="ti ti-category"></i>
                        <span class="menu-text">Kategori</span>
                    </a>
                </li>

                <li data-title="Buku">
                    <a href="{{ route('admin.books') }}"
                        class="{{ request()->routeIs('admin.books') ? 'active' : '' }}">
                        <i class="ti ti-book"></i>
                        <span class="menu-text">Buku</span>
                    </a>
                </li>

                <li data-title="User">
                    <a href="{{ route('admin.users') }}"
                        class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                        <i class="ti ti-users"></i>
                        <span class="menu-text">User</span>
                    </a>
                </li>

                <li data-title="Peminjaman">
                    <a href="{{ route('admin.transactions') }}"
                        class="{{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
                        <i class="ti ti-clipboard-text"></i>
                        <span class="menu-text">Peminjaman</span>
                    </a>
                </li>

            </ul>

        </aside>


        <!-- PAGE WRAPPER -->
        <div id="pageWrapper" class="page-wrapper">

            <div class="header">

                <div class="d-flex align-items-center gap-3">

                    <i id="toggleSidebar" class="ti ti-menu-2 toggle-btn"></i>

                    <i id="toggleMode" class="ti ti-moon mode-btn"></i>

                </div>

                <div class="d-flex align-items-center gap-3">

                    <div>
                        👤 {{ auth()->user()->name }}
                        <span class="badge bg-blue-lt">Admin</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">
                            Logout
                        </button>
                    </form>

                </div>

            </div>


            <div class="p-4">
                @yield('content')
            </div>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    <script>
        const sidebar = document.getElementById("sidebar")
        const pageWrapper = document.getElementById("pageWrapper")

        const toggleSidebar = document.getElementById("toggleSidebar")
        const toggleMode = document.getElementById("toggleMode")

        /* TOGGLE SIDEBAR */

        toggleSidebar.onclick = function() {

            sidebar.classList.toggle("collapsed")
            pageWrapper.classList.toggle("collapsed")

        }

        /* MODE SWITCH */

        toggleMode.onclick = function() {

            if (sidebar.classList.contains("dark")) {

                sidebar.classList.remove("dark")
                sidebar.classList.add("light")

                toggleMode.classList.remove("ti-moon")
                toggleMode.classList.add("ti-sun")

            } else {

                sidebar.classList.remove("light")
                sidebar.classList.add("dark")

                toggleMode.classList.remove("ti-sun")
                toggleMode.classList.add("ti-moon")

            }

        }
    </script>


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