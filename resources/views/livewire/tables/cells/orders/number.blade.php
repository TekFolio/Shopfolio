@can('read_orders')
    <a href="{{ route('shopfolio.orders.show', $order) }}" class="truncate font-medium text-secondary-900 hover:text-secondary-700 dark:text-white dark:hover:text-secondary-300">
        <span>{{ $order->number }}</span>
    </a>
@else
    <span>{{ $order->number }}</span>
@endcan
