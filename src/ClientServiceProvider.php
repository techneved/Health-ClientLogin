<?php
namespace Techneved\Client;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    /** Boot  */
    public function boot()
    {
        $this->registerResources();
        $this->mergeAuthFileFrom(__DIR__ . '/../config/auth.php', 'auth');
    }

    /** Register  */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/client.php', 'client');
    }




    public function registerResources()
    {
     
        $this->registerMigrations();
        $this->registerRoutes();
    }

     /**
     * Register migrations
     * 
     * @return void
     */
    public function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register routes
     * 
     * @return void
     */
    public function registerRoutes()
    {
        Route::group($this->routesConfiguration(), function() {

            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

     /**
     * Routes configuration
     * 
     * @return array
     */
    public function routesConfiguration()
    {
        return config('client.routes');
    }


     /** 
     * Merge auth configuration file
     * 
     * @return object
     */

    protected function mergeAuthFileFrom($path, $key)
    {
        $original = $this->app['config']->get($key, []);
        $this->app['config']->set($key, $this->multi_array_merge(require $path, $original));
    }

    /** 
     * Merge multi auth configuration file into original configuration file
     * 
     * @return object
     */
    protected function multi_array_merge($toMerge, $original)
    {
        $auth = [];
        foreach ($original as $key => $value) {
            if (isset($toMerge[$key])) {
                $auth[$key] = array_merge($value, $toMerge[$key]);
            } else {
                $auth[$key] = $value;
            }
        }

        return $auth;
    }
}
