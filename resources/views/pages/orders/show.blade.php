<x-shopfolio::layouts.app :title="__('Detail Order ~ :number', ['number' => $order->number])">

    <livewire:shopfolio-orders.show :order="$order" />

</x-shopfolio::layouts.app>
