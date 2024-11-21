<?php

namespace App\Providers;

use Filament\Panel;
use Filament\Tables\Actions\DeleteAction as TableDeleteAction;
use Filament\Tables\Actions\EditAction as TableEditAction;
use Filament\Tables\Actions\ViewAction as TableViewAction;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        Model::unguard();
        Model::shouldBeStrict();

        static::configPanel();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public function configPanel(): void
    {
        Panel::configureUsing(function (Panel $panel) {
            $panel
                ->spa(false)
                ->profile(isSimple: false);
        });

        TableViewAction::configureUsing(function (TableViewAction $action) {
            $action
                ->slideOver()
                ->label('')
                ->color('warning')
                ->icon('heroicon-o-eye');
        }, isImportant: true);

        TableEditAction::configureUsing(function (TableEditAction $action) {
            $action
                ->slideOver()
                ->label('')
                ->icon('heroicon-o-pencil');
        }, isImportant: true);

        TableDeleteAction::configureUsing(function (TableDeleteAction $action) {
            $action
                ->label('')
                ->icon('heroicon-o-trash');
        }, isImportant: true);

        Table::configureUsing(function (Table $table) {
            $table
                ->actionsPosition(ActionsPosition::BeforeColumns);
        });

    }
}
