<x-shopfolio::layouts.app :title="__('shopfolio::pages/products.reviews.view', ['product' => $review->reviewrateable->name])">

    <livewire:shopfolio-reviews.show :review="$review" />

</x-shopfolio::layouts.app>
