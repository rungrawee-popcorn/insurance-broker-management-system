<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <!-- ========================= -->
    <!-- TOP BAR -->
    <!-- ========================= -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- NAV LINKS -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                        Customers
                    </x-nav-link>

                    <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                        Companies
                    </x-nav-link>

                    <x-nav-link :href="route('policies.index')" :active="request()->routeIs('policies.*')">
                        Policies
                    </x-nav-link>

                    <!-- ========================= -->
                    <!-- REPORTS (PHASE 10) -->
                    <!-- ========================= -->

                    <x-nav-link :href="route('reports.customers')" :active="request()->routeIs('reports.customers')">
                        Customer Report
                    </x-nav-link>

                    <x-nav-link :href="route('reports.policies')" :active="request()->routeIs('reports.policies')">
                        Policy Report
                    </x-nav-link>

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <!-- SEARCH BOX -->
                <div class="relative mr-4">
                    <input id="globalSearch"
                           type="text"
                           placeholder="Search..."
                           class="border rounded-md px-3 py-1 text-sm">

                    <div id="searchResults"
                         class="absolute bg-white border w-80 mt-1 shadow-lg hidden z-50">
                    </div>
                </div>

                <!-- USER DROPDOWN -->
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-600 hover:text-gray-900">

                            <div class="text-right">
                                <div class="font-medium">
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    Role: {{ Auth::user()->role->name ?? 'No Role' }}
                                </div>
                            </div>

                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <!-- LOGOUT -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- MOBILE MENU BUTTON -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="p-2 text-gray-400 hover:text-gray-500">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- ========================= -->
    <!-- MOBILE MENU -->
    <!-- ========================= -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                Customers
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                Companies
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('policies.index')" :active="request()->routeIs('policies.*')">
                Policies
            </x-responsive-nav-link>

            <!-- ========================= -->
            <!-- REPORTS (MOBILE) -->
            <!-- ========================= -->

            <x-responsive-nav-link :href="route('reports.customers')" :active="request()->routeIs('reports.customers')">
                Customer Report
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reports.policies')" :active="request()->routeIs('reports.policies')">
                Policy Report
            </x-responsive-nav-link>

        </div>

        <!-- MOBILE USER -->
        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>

                <div class="text-sm text-gray-500">
                    Role: {{ Auth::user()->role->name ?? 'No Role' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>

<!-- ========================= -->
<!-- SEARCH SCRIPT (UNCHANGED) -->
<!-- ========================= -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('globalSearch');
    const box = document.getElementById('searchResults');

    if (!input || !box) return;

    let timeout = null;

    input.addEventListener('input', function () {

        clearTimeout(timeout);

        timeout = setTimeout(() => {

            const query = this.value.trim();

            if (query.length < 2) {
                box.classList.add('hidden');
                box.innerHTML = '';
                return;
            }

            fetch(`/search?q=${query}`)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    if (data.customers?.length > 0) {
                        html += `<div class="p-2 bg-gray-100 text-xs font-bold">Customers</div>`;
                        data.customers.forEach(c => {
                            html += `<a href="/customers/${c.id}" class="block px-3 py-2 hover:bg-gray-100 text-sm border-b">${c.first_name} ${c.last_name}</a>`;
                        });
                    }

                    if (data.companies?.length > 0) {
                        html += `<div class="p-2 bg-gray-100 text-xs font-bold">Companies</div>`;
                        data.companies.forEach(c => {
                            html += `<a href="/companies/${c.id}" class="block px-3 py-2 hover:bg-gray-100 text-sm border-b">${c.name}</a>`;
                        });
                    }

                    if (data.policies?.length > 0) {
                        html += `<div class="p-2 bg-gray-100 text-xs font-bold">Policies</div>`;
                        data.policies.forEach(p => {
                            html += `<a href="/policies/${p.id}" class="block px-3 py-2 hover:bg-gray-100 text-sm border-b">${p.policy_number}</a>`;
                        });
                    }

                    if (html === '') {
                        html = `<div class="p-3 text-sm text-gray-500">No results found</div>`;
                    }

                    box.innerHTML = html;
                    box.classList.remove('hidden');
                });

        }, 300);
    });

    document.addEventListener('click', function (e) {
        if (!box.contains(e.target) && e.target !== input) {
            box.classList.add('hidden');
        }
    });

});
</script>