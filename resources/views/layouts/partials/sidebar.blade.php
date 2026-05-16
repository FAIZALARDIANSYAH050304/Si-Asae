<aside class="fixed top-0 left-0 z-40 w-64 h-screen bg-white border-r border-gray-200">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <!-- Logo -->
        <div class="flex items-center mb-5">
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <i class="bi bi-building text-2xl text-blue-600 me-2"></i>
<span class="self-center text-xl font-semibold whitespace-nowrap text-gray-900">SI-ASAE</span>
            </a>
        </div>

        <!-- Menu -->
        <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-house-door text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <!-- Warga Binaan -->
            <li>
                <a href="{{ route('warga-binaan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('warga-binaan.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-people text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Warga Binaan</span>
                </a>
            </li>

            <!-- Program Asimilasi -->
            <li>
                <a href="{{ route('program-asimilasi.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('program-asimilasi.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-book text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Program Asimilasi</span>
                </a>
            </li>

            <!-- Kegiatan -->
            <li>
                <a href="{{ route('kegiatans.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('kegiatans.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-calendar-event text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Monitoring Kegiatan</span>
                </a>
            </li>

            <!-- Absensi -->
            <li>
                <a href="{{ route('absensi.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('absensi.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-qr-code-scan text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Absensi QR Code</span>
                </a>
            </li>

            <!-- Penilaian -->
            <li>
                <a href="{{ route('penilaian.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('penilaian.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-star text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Penilaian & Evaluasi</span>
                </a>
            </li>

            <!-- Pelanggaran -->
            <li>
                <a href="{{ route('pelanggaran.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('pelanggaran.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-exclamation-triangle text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Pelanggaran</span>
                </a>
            </li>

            <!-- Laporan -->
            <li>
                <a href="{{ route('laporan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('laporan.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-file-earmark-text text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Laporan</span>
                </a>
            </li>

            <!-- Activity Log -->
            <li>
                <a href="{{ route('activity-log.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('activity-log.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-clock-history text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Activity Log</span>
                </a>
            </li>

            @role('admin')
            <!-- User Management (Admin Only) -->
            <li>
                <a href="{{ route('users.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-blue-50 group {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="bi bi-person-gear text-gray-500 group-hover:text-blue-600"></i>
                    <span class="ms-3">Manajemen User</span>
                </a>
            </li>
            @endrole
        </ul>

        <!-- Logout -->
        <div class="absolute bottom-0 left-0 w-full p-3 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-red-50 group">
                    <i class="bi bi-box-arrow-left text-gray-500 group-hover:text-red-600"></i>
                    <span class="ms-3 text-gray-900 group-hover:text-red-600">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
