<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Filament\Resources\CustomerResource\Pages\ListCustomers;
use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomersStatsOverview extends BaseWidget
{
    protected function getTablePage(): string
    {
        return ListCustomers::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('customer.widget.title.total'), Customer::count())
                ->description(__('customer.widget.description.total'))
                ->color('primary')
                ->icon('heroicon-c-user-group'),
                //->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(__('customer.widget.title.active'), Customer::where('status_id', 1)->count())
                ->description(__('customer.widget.description.active'))
                ->color('success')
                ->icon('heroicon-m-arrow-trending-up'),
            Stat::make(__('customer.widget.title.inactive'), Customer::where('status_id', 2)->count())
                ->description(__('customer.widget.description.inactive'))
                ->color('danger')
                ->icon('heroicon-m-arrow-trending-down'),
        ];
    }
}
