<?php

namespace App\Filament\Resources\RegisterCustomerResource\Widgets;

use App\Models\RegisterCustomer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegisterCustomerOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('register_customer.widget.title.total'), RegisterCustomer::count())
                ->description(__('register_customer.widget.description.total'))
                ->color('primary')
                ->icon('heroicon-c-user-group'),
                //->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(__('register_customer.widget.title.active'), RegisterCustomer::where('active', 1)->count())
                ->description(__('register_customer.widget.description.active'))
                ->color('success')
                ->icon('heroicon-m-arrow-trending-up'),
            Stat::make(__('register_customer.widget.title.inactive'), RegisterCustomer::where('active', 0)->count())
                ->description(__('register_customer.widget.description.inactive'))
                ->color('danger')
                ->icon('heroicon-m-arrow-trending-down'),
        ];
    }
}
