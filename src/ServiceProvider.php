<?php

namespace RebelWalls\PdfLibHelper;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/pdflib-builder.php', 'pdflib-builder'
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/pdflib-builder.php' => config_path('pdflib-builder.php'),
        ]);
    }
}
