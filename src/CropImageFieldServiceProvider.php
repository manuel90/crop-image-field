<?php

namespace Manuel90\CropImageField;

use Illuminate\Support\ServiceProvider;

use Manuel90\CropImageField\FormFields\CropImageFormField;

class CropImageFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/cropimage.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cropimage');
        $this->loadTranslationsFrom(__DIR__.'/../publishable/lang', 'cropimage');
        $this->publishes([__DIR__."/assets" => public_path('manuel90/cropimage')], 'public');

        if( class_exists('\TCG\Voyager\Facades\Voyager') ) {
            \TCG\Voyager\Facades\Voyager::addFormField(CropImageFormField::class);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
