<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Setting Menu
    |--------------------------------------------------------------------------
    |
    | The menu for the generation of the page settings and layout.
    | BladeUIKit Heroicon is the icon used. See https://blade-ui-kit.com/blade-icons?set=1
    |
    */

    'items' => [
        [
            'name' => 'General',
            'description' => 'View and update your store information.',
            'icon' => 'heroicon-o-cog',
            'route' => 'shopfolio.settings.shop',
            'permission' => null,
        ],
        [
            'name' => 'Staff & permissions',
            'description' => 'View and manage what staff can see or do in your store.',
            'icon' => 'heroicon-o-users',
            'route' => 'shopfolio.settings.users',
            'permission' => null,
        ],
        [
            'name' => 'Email',
            'description' => 'Manage email notifications that will be sent to your customers.',
            'icon' => 'heroicon-o-mail',
            'route' => 'shopfolio.settings.mails',
            'permission' => null,
        ],
        [
            'name' => 'Locations',
            'description' => 'Manage the places you stock inventory and sell products.',
            'icon' => 'heroicon-o-location-marker',
            'route' => 'shopfolio.settings.inventories.index',
            'permission' => null,
        ],
        [
            'name' => 'Attributes',
            'description' => 'Manage additional attributes for your products.',
            'icon' => 'heroicon-o-clipboard-list',
            'route' => 'shopfolio.settings.attributes.index',
            'permission' => null,
        ],
        [
            'name' => 'Shipping and delivery',
            'description' => 'Manage how you ship orders to customers.',
            'icon' => 'heroicon-o-truck',
            'route' => null,
            'permission' => null,
        ],
        [
            'name' => 'Integrations',
            'description' => 'Connect with third-party tools that you’re already using.',
            'icon' => 'heroicon-o-clipboard-list',
            'route' => null,
            'permission' => null,
        ],
        [
            'name' => 'Analytics',
            'description' => 'Get a better understanding of where your traffic is coming from.',
            'icon' => 'heroicon-o-chart-bar',
            'route' => 'shopfolio.settings.analytics',
            'permission' => null,
        ],
        [
            'name' => 'Taxes',
            'description' => 'Manage how your store charges taxes.',
            'icon' => 'heroicon-o-receipt-tax',
            'route' => null,
            'permission' => null,
        ],
        [
            'name' => 'Payment methods',
            'description' => 'Add different payment methods for your customers.',
            'icon' => 'heroicon-o-credit-card',
            'route' => 'shopfolio.settings.payments',
            'permission' => null,
        ],
        [
            'name' => 'Files',
            'description' => 'Manage store assets (images, videos and documents).',
            'icon' => 'heroicon-o-paper-clip',
            'route' => null,
            'permission' => null,
        ],
        [
            'name' => 'Legal',
            'description' => 'Manage your store\'s legal pages such as privacy, terms.',
            'icon' => 'heroicon-o-lock-closed',
            'route' => 'shopfolio.settings.legal',
            'permission' => null,
        ],
    ],
];
