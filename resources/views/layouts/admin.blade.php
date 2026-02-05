<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - {{ config('app.name', 'Penguatan Olahraga') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --info-color: #17a2b8;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --sidebar-active: #475569;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f172a 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-logo i {
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .sidebar.collapsed .sidebar-logo span {
            display: none;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: background 0.3s;
        }

        .sidebar-toggle:hover {
            background: var(--sidebar-hover);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
            display: block;
        }

        .sidebar.collapsed .menu-section-title {
            display: none;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .menu-item:hover {
            background: var(--sidebar-hover);
            color: white;
            border-left-color: var(--primary-color);
        }

        .menu-item.active {
            background: var(--sidebar-active);
            color: white;
            border-left-color: var(--primary-color);
        }

        .menu-item i {
            width: 24px;
            font-size: 1.125rem;
            margin-right: 0.75rem;
            text-align: center;
        }

        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .menu-item .badge {
            margin-left: auto;
            font-size: 0.7rem;
        }

        .sidebar.collapsed .menu-item .badge {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .top-bar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }

        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-menu:hover {
            background: #e9ecef;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-card.primary { border-left-color: var(--primary-color); }
        .stat-card.success { border-left-color: var(--success-color); }
        .stat-card.info { border-left-color: var(--info-color); }
        .stat-card.warning { border-left-color: var(--warning-color); }
        .stat-card.danger { border-left-color: var(--danger-color); }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 1rem;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-shield-alt"></i>
                <span>Admin Panel</span>
            </div>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-menu">
            <!-- Dashboard -->
            <div class="menu-section">
                <a href="{{ route('admin.dashboard') }}" 
                   class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Manajemen Peserta -->
            <div class="menu-section">
                <span class="menu-section-title">Manajemen</span>
                <a href="{{ route('admin.peserta.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.peserta.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Peserta</span>
                </a>
            </div>

            <!-- Modul Kebugaran -->
            <div class="menu-section">
                <span class="menu-section-title">Kebugaran</span>
                <a href="{{ route('admin.fitness.sports.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.fitness.sports.*') ? 'active' : '' }}">
                    <i class="fas fa-dumbbell"></i>
                    <span>Olahraga</span>
                </a>
                <a href="{{ route('admin.fitness.schedules.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.fitness.schedules.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Latihan</span>
                </a>
            </div>

            <!-- Modul Psikososial -->
            <div class="menu-section">
                <span class="menu-section-title">Psikososial</span>
                <a href="{{ route('admin.psychosocial.activities.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.psychosocial.activities.*') ? 'active' : '' }}">
                    <i class="fas fa-heartbeat"></i>
                    <span>Kegiatan</span>
                </a>
                <a href="{{ route('admin.psychosocial.notes.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.psychosocial.notes.*') ? 'active' : '' }}">
                    <i class="fas fa-sticky-note"></i>
                    <span>Catatan</span>
                </a>
            </div>

            <!-- Modul Bencana -->
            <div class="menu-section">
                <span class="menu-section-title">Kesiapsiagaan</span>
                <a href="{{ route('admin.disaster.materials.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.disaster.materials.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Materi Bencana</span>
                </a>
                <a href="{{ route('admin.disaster.simulations.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.disaster.simulations.*') ? 'active' : '' }}">
                    <i class="fas fa-fire"></i>
                    <span>Simulasi</span>
                </a>
            </div>

            <!-- Absensi & Laporan -->
            <div class="menu-section">
                <span class="menu-section-title">Absensi & Laporan</span>
                <a href="{{ route('admin.attendance.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Absensi</span>
                </a>
                <a href="{{ route('admin.reports.activity') }}" 
                   class="menu-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </div>

            <!-- Badge & Achievement -->
            <div class="menu-section">
                <span class="menu-section-title">Sistem</span>
                <a href="{{ route('admin.badges.index') }}" 
                   class="menu-item {{ request()->routeIs('admin.badges.*') ? 'active' : '' }}">
                    <i class="fas fa-award"></i>
                    <span>Badge</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h1 class="top-bar-title mb-0">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="top-bar-actions">
                <div class="user-menu">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                        <small class="text-muted">Administrator</small>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <strong><i class="fas fa-exclamation-circle me-2"></i>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        // Load sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });

        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Auto-hide dismissible alerts only
        document.querySelectorAll('.alert.alert-dismissible').forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>
