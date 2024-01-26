<nav class="bg-white shadow">
    <div class="px-5">
        <div class="relative flex h-16 justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!--
                      Icon when menu is closed.

                      Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!--
                      Icon when menu is open.

                      Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <!-- Current: "border-indigo-500 text-gray-900", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
                    @if($owner->roles->first()->name === 'root')<a href="{{route('get_company')}}" id="company-column" class="inline-flex items-center  border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900">Companies</a>@endif
                    @if($owner->roles->first()->name === 'root')<a href="{{route('get_user')}}" id="user-column" class="inline-flex items-center  border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900">Users</a>@endif
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
{{--                <button type="button" class="relative rounded-full bg-white p-1.jpg text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">--}}
{{--                    <span class="absolute -inset-1.jpg.5"></span>--}}
{{--                    <span class="sr-only">View notifications</span>--}}
{{--                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.jpg.5" stroke="currentColor" aria-hidden="true">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.jpg.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.jpg.085 5.455 1.jpg.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />--}}
{{--                    </svg>--}}
{{--                </button>--}}
                <span type="button" class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="ml-50">{{$owner->name}}</span>
                </span>
                <!-- Profile dropdown -->
                <div class="relative ml-3">
                    <div>
                        <button id="profile" type="button" class="relative flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="absolute -inset-1.5"></span>
                            <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        </a>
                    </div>

                    <!--
                      Dropdown menu, show/hide based on menu state.

                      Enterin   g: "transition ease-out duration-200"
                        From: "transform opacity-0 scale-95"
                        To: "transform opacity-100 scale-100"
                      Leaving: "transition ease-in duration-75"
                        From: "transform opacity-100 scale-100"
                        To: "transform opacity-0 scale-95"
                    -->
{{--                    <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1.jpg shadow-lg ring-1.jpg ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1.jpg">--}}
{{--                        <!-- Active: "bg-gray-100", Not Active: "" -->--}}
{{--                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1.jpg" id="user-menu-item-0">Your Profile</a>--}}
{{--                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1.jpg" id="user-menu-item-1.jpg">Settings</a>--}}
{{--                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1.jpg" id="user-menu-item-2">Sign out</a>--}}
{{--                    </div>--}}
                </div>
                <div class="mt-4 sm:mt-0 sm:flex-none">
                    <button type="button" style="background-color: #ef4d4d; margin-left: 5px;" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><a href="{{route('logout')}}">Log out</a></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 pb-4 pt-2">
            <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
            <a href="#" class="block border-l-4 border-indigo-500 bg-indigo-50 py-2 pl-3 pr-4 text-base font-medium text-indigo-700">Dashboard</a>
            <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Team</a>
            <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Projects</a>
            <a href="#" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Calendar</a>
        </div>
    </div>

    <script>
        let company = document.getElementById('company-column');
        let user = document.getElementById('user-column');
        let domain = document.getElementById('domain-column');
        let link = document.getElementById('link-column');

        company?.addEventListener('click', () => {
            localStorage.removeItem('active-tab');
            localStorage.setItem('active-tab', 'company');
        });

        user?.addEventListener('click', () => {
            localStorage.removeItem('active-tab');
            localStorage.setItem('active-tab', 'user');
        });

        domain?.addEventListener('click', () => {
            localStorage.removeItem('active-tab');
            localStorage.setItem('active-tab', 'domain');
        });

        link?.addEventListener('click', () => {
            localStorage.removeItem('active-tab');
            localStorage.setItem('active-tab', 'link');
        });

        switch (localStorage.getItem('active-tab')) {
            case 'company':
                company.classList.add('border-b-2');

                break;
            case 'user':
                user.classList.add('border-b-2');

                break;
            case 'domain':
                domain.classList.add('border-b-2');

                break;
            case 'link':
                link.classList.add('border-b-2');

                break;
        }
    </script>
</nav>
