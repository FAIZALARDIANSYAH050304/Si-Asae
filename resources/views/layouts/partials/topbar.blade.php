<header class="sticky top-0 z-30 bg-white border-b border-gray-200">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">
            <!-- Left Side -->
            <div class="flex items-center">
                <h2 class="text-lg font-semibold text-gray-900">
@yield('title', 'SI-ASAE - Sistem Informasi Asimilasi dan Edukasi')
                </h2>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button type="button" class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="bi bi-bell text-xl"></i>
                    <span class="absolute top-1 right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </button>

                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100"
                    >
@if(auth()->user()->foto)
                            <img 
                                src="{{ asset('storage/' . auth()->user()->foto) }}" 
                                alt="{{ auth()->user()->name }}"
                                class="w-8 h-8 rounded-full object-cover"
                            >
                        @else
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-gray-900 hidden lg:block">
                            {{ auth()->user()->name }}
                        </span>
                        <i class="bi bi-chevron-down text-xs text-gray-500"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        x-transition 
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 hidden"
                        style="display: none;"
                    >
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="bi bi-person-circle me-2"></i>
                            Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="bi bi-box-arrow-left me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Simple dropdown toggle
    document.addEventListener('DOMContentLoaded', function() {
        const userButton = document.querySelector('[x-data] button');
        if (userButton) {
            userButton.addEventListener('click', function() {
                const dropdown = this.nextElementSibling;
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            });
        }
    });
</script>
