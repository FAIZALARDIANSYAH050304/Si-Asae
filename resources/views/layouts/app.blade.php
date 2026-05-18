<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'SI-ASAE') }}</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
.sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 270px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-right: 1px solid #e2e8f0;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 2px 0 8px rgba(0,0,0,0.02);
        }
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .main-content {
            margin-left: 270px;
            min-height: 100vh;
            background: #f8fafc;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .sidebar-logo {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        .sidebar-logo a {
            color: #fff !important;
        }
        .sidebar-logo .bi-building {
            font-size: 1.75rem;
        }
        .sidebar-menu {
            padding: 1rem 0.75rem;
        }
        .sidebar-section-title {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            padding: 0.75rem 0.75rem 0.5rem;
            margin-top: 0.5rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.625rem 0.875rem;
            color: #475569;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 2px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: #2563eb;
            border-radius: 0 4px 4px 0;
            transition: height 0.25s ease;
        }
        .sidebar-link:hover {
            background: linear-gradient(90deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #2563eb;
            transform: translateX(2px);
        }
        .sidebar-link:hover i {
            color: #2563eb;
            transform: scale(1.1);
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 100%);
            color: #2563eb;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }
        .sidebar-link.active::before {
            height: 60%;
        }
        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.125rem;
            color: #64748b;
            transition: all 0.25s ease;
            width: 20px;
            text-align: center;
        }
        .sidebar-user {
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .sidebar-user-info {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .sidebar-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
        }
        .sidebar-user-details {
            margin-left: 12px;
            flex: 1;
        }
        .sidebar-user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
        }
        .sidebar-user-role {
            font-size: 0.75rem;
            color: #64748b;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
<div class="sidebar-logo">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <i class="bi bi-building fs-4 me-2"></i>
                    <span class="fw-bold fs-5">SI-ASAE</span>
                </a>
            </div>
            
<div class="sidebar-menu">
                <div class="sidebar-section-title">Menu Utama</div>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a href="{{ route('warga-binaan.index') }}" class="sidebar-link {{ request()->routeIs('warga-binaan.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Warga Binaan
                </a>
                <a href="{{ route('program-asimilasi.index') }}" class="sidebar-link {{ request()->routeIs('program-asimilasi.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i> Program Asimilasi
                </a>
                
                <div class="sidebar-section-title">Aktivitas</div>
                <a href="{{ route('kegiatans.index') }}" class="sidebar-link {{ request()->routeIs('kegiatans.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event"></i> Monitoring Kegiatan
                </a>
                <a href="{{ route('absensi.index') }}" class="sidebar-link {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                    <i class="bi bi-qr-code-scan"></i> Absensi QR Code
                </a>
                <a href="{{ route('penilaian.index') }}" class="sidebar-link {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i> Penilaian & Evaluasi
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="sidebar-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle"></i> Pelanggaran
                </a>
                
                <div class="sidebar-section-title">Sistem</div>
                <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </a>
                <a href="{{ route('activity-log.index') }}" class="sidebar-link {{ request()->routeIs('activity-log.*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Activity Log
                </a>
                
@auth
                @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> Manajemen User
                </a>
                @endif
                @endauth
            </div>
            
            <!-- User Profile Section -->
            <div class="sidebar-user">
                <div class="sidebar-user-info">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="sidebar-user-details">
                        <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-user-role">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="sidebar-link text-danger w-100 border-0 bg-transparent text-start">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Topbar -->
<header class="topbar d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 fw-semibold">@yield('title', 'SI-ASAE')</h4>
                </div>
                <div class="d-flex align-items-center">
<span class="me-3 text-muted">{{ auth()->user()->name ?? 'User' }}</span>
                    <div class="dropdown">
                        <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-left me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Toast Notification
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session("success") }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session("error") }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        // Delete Confirmation
        function confirmDelete(url, title = 'Apakah Anda yakin?', text = 'Data yang dihapus tidak dapat dikembalikan!') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
            return false;
        }
    </script>
    
    @stack('scripts')
</body>
</html>
