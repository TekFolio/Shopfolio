<div>
    <x-shopfolio::breadcrumb back="shopfolio.collections.index">
        <x-heroicon-s-chevron-left class="shrink-0 h-5 w-5 text-secondary-400" />
        <x-shopfolio::breadcrumb.link :link="route('shopfolio.collections.index')" title="shopfolio::layout.sidebar.collections" />
    </x-shopfolio::breadcrumb>

    <x-shopfolio::heading class="mt-3">
        <x-slot name="title">
            {{ $name }}
        </x-slot>

        <x-slot name="action">
            <x-shopfolio::buttons.primary wire:click="store" wire.loading.attr="disabled" type="button">
                <x-shopfolio::loader wire:loading wire:target="store" class="text-white" />
                {{ __('shopfolio::layout.forms.actions.update') }}
            </x-shopfolio::buttons.primary>
        </x-slot>
    </x-shopfolio::heading>

    <div class="mt-6 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-6 lg:gap-6">
        <div class="lg:col-span-4 space-y-5">
            <div class="bg-white rounded-lg shadow p-4 sm:p-5 dark:bg-secondary-800">
                <x-shopfolio::forms.group label="shopfolio::layout.forms.label.name" for="name" isRequired :error="$errors->first('name')">
                    <x-shopfolio::forms.input wire:model.defer="name" id="name" type="text" autocomplete="off" placeholder="{{ __('Summers Collections, Christmas promotions...') }}" />
                </x-shopfolio::forms.group>
                <div class="mt-5">
                    <x-shopfolio::forms.group label="shopfolio::layout.forms.label.description" for="description">
                        <livewire:shopfolio-forms.trix :value="$description" />
                    </x-shopfolio::forms.group>
                </div>
            </div>

            <livewire:shopfolio-collections.products :collection="$collection" />

            <x-shopfolio::forms.seo
                slug="collections"
                :title="$seoTitle"
                :url="$collection->slug"
                :description="$seoDescription"
                :canUpdate="$updateSeo"
            />
        </div>
        <div class="lg:col-span-2">
            <aside class="sticky top-6 space-y-5">
                <div class="bg-white rounded-md shadow p-4 sm:p-5 dark:bg-secondary-800">
                    <x-datetime-picker
                        :label="__('shopfolio::layout.forms.label.availability')"
                        :placeholder="__('shopfolio::layout.forms.placeholder.pick_a_date')"
                        wire:model="publishedAt"
                        parse-format="YYYY-MM-DD HH:mm"
                        time-format="24"
                        without-timezone
                        class="dark:bg-secondary-700"
                    />
                    @if($publishedAt)
                        <div class="mt-2 flex items-start">
                            <div class="mt-1 shrink-0 w-2.5 h-2.5 rounded-full bg-primary-600"></div>
                            <p class="ml-2.5 text-sm text-secondary-500 leading-5 dark:text-secondary-400">
                                {{ __('shopfolio::messages.published_on') }} <br>
                                {{ $publishedAtFormatted }}
                            </p>
                        </div>
                    @else
                        <p class="mt-2 text-sm leading-5 text-secondary-500 dark:text-secondary-400">
                            {{ __('shopfolio::pages/collections.availability_description') }}
                        </p>
                    @endif
                </div>
                <div class="bg-white rounded-md shadow overflow-hidden p-4 sm:p-5 dark:bg-secondary-800">
                    <h4 class="block text-sm font-medium leading-5 text-secondary-700 dark:text-secondary-300">{{ __('shopfolio::layout.forms.label.image_preview') }}</h4>
                    <div class="mt-1">
                        <livewire:shopfolio-forms.uploads.single :media="$collection->getFirstMedia(config('shopfolio.system.storage.disks.uploads'))" />
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <div class="mt-6 border-t border-secondary-200 pt-5 pb-10 dark:border-secondary-700">
        <div class="flex justify-end">
            <x-shopfolio::buttons.primary wire:click="store" wire.loading.attr="disabled" type="button">
                <x-shopfolio::loader wire:loading wire:target="store" class="text-white" />
                {{ __('shopfolio::layout.forms.actions.update') }}
            </x-shopfolio::buttons.primary>
        </div>
    </div>
</div>
