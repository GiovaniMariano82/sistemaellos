<?php

namespace App\Filament\Resources\ServiceResource\Widgets;

use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ServicesStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('service.widget.title.total'), Service::count())
                ->description(__('service.widget.description.total'))
                ->color('primary')
                ->icon('heroicon-c-user-group'),
            Stat::make(__('service.widget.title.active'), Service::where('active', 1)->count())
                ->description(__('service.widget.description.active'))
                ->color('success')
                ->icon('heroicon-m-arrow-trending-up'),
            Stat::make(__('service.widget.title.inactive'), Service::where('active', 0)->count())
                ->description(__('service.widget.description.inactive'))
                ->color('danger')
                ->icon('heroicon-m-arrow-trending-down'),
        ];
    }
}
