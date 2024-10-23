<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('product.widget.title.total'), Product::count())
                ->description(__('product.widget.description.total'))
                ->color('primary')
                ->icon('heroicon-c-user-group'),
            Stat::make(__('product.widget.title.active'), Product::where('active', 1)->count())
                ->description(__('product.widget.description.active'))
                ->color('success')
                ->icon('heroicon-m-arrow-trending-up'),
            Stat::make(__('product.widget.title.inactive'), Product::where('active', 0)->count())
                ->description(__('product.widget.description.inactive'))
                ->color('danger')
                ->icon('heroicon-m-arrow-trending-down'),
        ];
    }
}
