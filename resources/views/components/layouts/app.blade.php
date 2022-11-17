<x-shopfolio::layouts.base :title="$title ?? null">

    <div class="h-screen flex overflow-hidden" x-data="{ sidebarOpen: false, modalDemo: false }" @keydown.window.escape="sidebarOpen = false">
        <x-shopfolio::layouts.app.sidebar />

        <x-shopfolio::layouts.app.sidebar.mobile />

        <div class="flex flex-col w-0 flex-1 overflow-hidden overflow-y-auto">
            <x-shopfolio::layouts.app.header />

            <main class="flex-1 relative z-0 py-3 lg:py-6">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 min-h-(screen-content)">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <x-shopfolio::wip />
    </div>

</x-shopfolio::layouts.base>
