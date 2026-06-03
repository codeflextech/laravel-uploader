<?php
declare(strict_types = 1);
namespace CodeFlexTech\Uploader;

use Illuminate\Support\ServiceProvider;

/**
 * Class UploadServiceProvider
 *
 * @package   CodeFlexTech\Uploader
 *
 * @author    Faisal Shah <faisalshah4004@gmail.com>
 *
 * @copyright 2026 CodeFlexTech.com
 * @version   1.0
 */
class UploadServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/uploader.php', 'uploader'
        );
    }

    /**
     * Function boot
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/uploader.php' => config_path('uploader.php'),
        ], 'uploader-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
