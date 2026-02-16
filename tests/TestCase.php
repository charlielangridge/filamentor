<?php

namespace Geosem42\Filamentor\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Geosem42\Filamentor\FilamentorServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Geosem42\\Filamentor\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );

        if (! Schema::hasTable('filamentor_pages')) {
            Schema::create('filamentor_pages', function (Blueprint $table): void {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->json('layout')->nullable();
                $table->boolean('is_published')->default(false);
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('og_image')->nullable();
                $table->timestamps();
            });
        }

    }

    protected function getPackageProviders($app)
    {
        $providers = [
            AdminPanelProvider::class,
            FilamentorServiceProvider::class,
        ];

        $optionalProviders = [
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            LivewireServiceProvider::class,
        ];

        foreach ($optionalProviders as $provider) {
            if (class_exists($provider)) {
                $providers[] = $provider;
            }
        }

        $filamentProviders = [
            'Filament\\FilamentServiceProvider',
            'Filament\\Actions\\ActionsServiceProvider',
            'Filament\\Forms\\FormsServiceProvider',
            'Filament\\Infolists\\InfolistsServiceProvider',
            'Filament\\Notifications\\NotificationsServiceProvider',
            'Filament\\Schemas\\SchemasServiceProvider',
            'Filament\\Support\\SupportServiceProvider',
            'Filament\\Tables\\TablesServiceProvider',
            'Filament\\Widgets\\WidgetsServiceProvider',
        ];

        foreach ($filamentProviders as $provider) {
            if (class_exists($provider)) {
                $providers[] = $provider;
            }
        }

        return $providers;
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filamentor_table.php.stub';
        $migration->up();
        */
    }
}
