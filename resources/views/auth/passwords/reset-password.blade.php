<x-shopfolio::layouts.base :title="__('shopfolio::pages/auth.reset.title')">

    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full px-6">
            <div class="space-y-4">
                <x-shopfolio::validation-errors />

                <div>
                    <x-shopfolio::brand class="mx-auto h-20 w-auto" />

                    <h2 class="mt-10 text-3xl font-extrabold font-heading text-center leading-9 text-secondary-900 dark:text-white">
                        {{ __('shopfolio::pages/auth.reset.title') }}
                    </h2>
                    <p class="mt-5 text-sm leading-5 text-center">
                        {{ __('shopfolio::pages/auth.reset.message') }}
                    </p>
                </div>
            </div>
            <form class="mt-5" action="{{ route('shopfolio.password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="rounded-md shadow-sm">
                    <div>
                        <input
                            aria-label="{{ __('shopfolio::layout.forms.label.email') }}"
                            value="{{ $email ?? old('email') }}"
                            name="email"
                            type="email"
                            autocomplete="off"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-secondary-300 dark:border-secondary-700 dark:bg-secondary-800 placeholder-secondary-500 text-secondary-900 dark:text-secondary-300 rounded-t-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-offset-secondary-900 focus:z-10 sm:text-sm"
                            placeholder="{{ __('shopfolio::layout.forms.label.email') }}"
                            required
                        />
                    </div>
                    <div class="-mt-px">
                        <input
                            aria-label="{{ __('shopfolio::layout.forms.label.password') }}"
                            name="password"
                            type="password"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-secondary-300 dark:border-secondary-700 dark:bg-secondary-800 placeholder-secondary-500 text-secondary-900 dark:text-secondary-300 rounded-b-md focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-offset-secondary-900 focus:z-10 sm:text-sm"
                            placeholder="{{ __('shopfolio::layout.forms.label.new_password') }}"
                            required
                        />
                    </div>
                </div>

                <div class="mt-5">
                    <x-shopfolio::buttons.primary type="submit" class="w-full justify-center">
                        {{ __('shopfolio::pages/auth.reset.action') }}
                    </x-shopfolio::buttons.primary>
                </div>
            </form>
        </div>
    </div>

</x-shopfolio::layouts.base>
