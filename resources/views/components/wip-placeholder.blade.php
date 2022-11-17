<div class="px-4 pt-5 pb-4 sm:p-6">
    <div>
        <h3 class="text-xl leading-6 font-medium text-secondary-900 dark:text-white">
            🛠 <span class="ml-4">{{ __('shopfolio::components.wip.title') }}</span>
        </h3>
        <p class="mt-1 max-w-4xl text-sm leading-5 text-secondary-500 dark:text-secondary-400">{{ __('shopfolio::components.wip.description') }}</p>
    </div>
    <div class="mt-5">
        <p class="flex items-center text-base font-medium text-secondary-900 dark:text-white">
            <x-heroicon-o-inbox-in class="h-5 w-5 mr-2" />
            {{ __('shopfolio::components.wip.sign_up') }}
        </p>
        <form action="https://laravelshopper.us2.list-manage.com/subscribe/post?u=d9bb29721fb442284ca02e956&amp;id=6800e9bbef" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" target="_blank" novalidate method="POST" class="mt-3 flex items-center">
            <div class="relative grow focus-within:z-10">
                <input type="hidden" name="b_d9bb29721fb442284ca02e956_6800e9bbef" tabindex="-1" value="">
                <x-shopfolio::forms.input
                    aria-label="{{ __('shopfolio::layout.forms.label.email') }}"
                    type="email"
                    value=""
                    name="EMAIL"
                    id="mce-EMAIL"
                    class="rounded-l-md rounded-r-none"
                    placeholder="{{ __('shopfolio::layout.forms.placeholder.email') }}"
                    required
                />
            </div>
            <x-shopfolio::buttons.primary class="-ml-px relative rounded-l-none rounded-r-md" type="submit">
                {{ __('shopfolio::layout.forms.actions.subscribe') }}
            </x-shopfolio::buttons.primary>
        </form>
    </div>
</div>
