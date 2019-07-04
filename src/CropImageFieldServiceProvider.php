<?php

namespace Manuel90\CropImageField;

use Illuminate\Support\ServiceProvider;

use Manuel90\CropImageField\FormFields\CropImageFormField;

use TCG\Voyager\Voyager;

class CropImageFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include __DIR__ . '/../routes/cropimage.php';
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
        Voyager::addFormField(CropImageFormField::class);

        $publishablePath = dirname(__DIR__).'/publishable';

        $this->publishes(["{$publishablePath}/assets/" => public_path('assets')]);
    }
}
