<?php

namespace App\Filament\Resources\ProviderResource\Widgets;

use App\Filament\Resources\ProviderResource\Pages\ListProviders;
use App\Models\Provider;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProvidersStatsOverview extends BaseWidget
{
    protected function getTablePage(): string
    {
        return ListProviders::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('provider.widget.title.total'), Provider::count())
                ->description(__('provider.widget.description.total'))
                ->color('primary')
                ->icon('heroicon-c-user-group'),
                //->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(__('provider.widget.title.active'), Provider::where('status_id', 1)->count())
                ->description(__('provider.widget.description.active'))
                ->color('success')
                ->icon('heroicon-m-arrow-trending-up'),
            Stat::make(__('provider.widget.title.inactive'), Provider::where('status_id', 2)->count())
                ->description(__('provider.widget.description.inactive'))
                ->color('danger')
                ->icon('heroicon-m-arrow-trending-down'),
        ];
    }
}
