<?php

namespace MdsDigital\CropImageField;

use Illuminate\Support\ServiceProvider;

use MdsDigital\CropImageField\FormFields\CropImageFormField;

class WelcomeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //include __DIR__ . '/../routes/myroutes.php';
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cropimage');

        $this->loadTranslationsFrom(realpath(__DIR__.'/../publishable/lang'), 'cropimage');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Voyager::addFormField(CropImageFormField::class);

        $publishablePath = dirname(__DIR__).'/publishable';
        
        $this->publishes(["{$publishablePath}/assets/" => public_path('assets')]);
    }
}
