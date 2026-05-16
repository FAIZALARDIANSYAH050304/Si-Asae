<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SI-LAPAS') }}</title>
    
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
            width: 260px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            overflow-y: auto;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .sidebar-logo {
            padding: 1.25rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .sidebar-menu {
            padding: 1rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 4px;
            transition: all 0.2s;
        }
        .sidebar-link:hover {
            background: #f3f4f6;
            color: #2563eb;
        }
        .sidebar-link.active {
            background: #eff6ff;
            color: #2563eb;
        }
        .sidebar-link i {
            margin-right: 12px;
            font-size: 1.25rem;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-logo">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none">
                    <i class="bi bi-building text-primary fs-4 me-2"></i>
                    <span class="fw-bold text-dark fs-5">SI-LAPAS</span>
                </a>
            </div>
            
            <div class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a href="{{ route('warga-binaan.index') }}" class="sidebar-link {{ request()->routeIs('warga-binaan.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Warga Binaan
                </a>
                <a href="{{ route('program-asimilasi.index') }}" class="sidebar-link {{ request()->routeIs('program-asimilasi.*') ? 'active' : '' }}">
                    <i class="bi bi-book"></i> Program Asimilasi
                </a>
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
                
                <hr class="my-3">
                
                <form method="POST" action="{{ route('logout') }}">
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
                    <h4 class="mb-0 fw-semibold">@yield('title', 'SI-LAPAS')</h4>
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
