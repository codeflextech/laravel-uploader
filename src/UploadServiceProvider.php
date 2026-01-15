<?php 
namespace CodeFlexTech\Uploader;

use Illuminate\Support\ServiceProvider;

class UploadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/uploader.php' => config_path('uploader.php'),
        ], 'uploader-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
