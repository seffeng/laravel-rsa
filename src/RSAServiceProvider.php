<?php
/**
 * @link http://github.com/seffeng/
 * @copyright Copyright (c) 2020 seffeng
 */
namespace Seffeng\LaravelRSA;

use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Seffeng\LaravelRSA\Exceptions\RSAException;
use Seffeng\LaravelRSA\Console\RSAGenerateKeyCommand;

class RSAServiceProvider extends BaseServiceProvider
{
    /**
     *
     * {@inheritDoc}
     * @see \Illuminate\Support\ServiceProvider::register()
     */
    public function register()
    {
        $this->registerAliases();
        $this->mergeConfigFrom($this->configPath(), 'rsa');

        $this->app->singleton('seffeng.laravel.rsa', function ($app) {
            $config = $app['config']->get('rsa');

            if ($config && is_array($config)) {
                return new RSA($config);
            } else {
                throw new RSAException('Please execute the command `php artisan vendor:publish --tag="rsa"` first to generate rsa configuration file.');
            }
        });

        $this->commands([
            RSAGenerateKeyCommand::class
        ]);
    }

    /**
     *
     * @author zxf
     * @date    2020年5月20日
     */
    public function boot()
    {
        if ($this->app->runningInConsole() && $this->app instanceof LaravelApplication) {
            $this->publishes([$this->configPath() => config_path('rsa.php')], 'rsa');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('rsa');
        }
    }

    /**
     *
     * @author zxf
     * @date    2020年5月20日
     */
    protected function registerAliases()
    {
        $this->app->alias('seffeng.laravel.rsa', RSA::class);
    }

    /**
     *
     * @author zxf
     * @date    2020年5月20日
     * @return string
     */
    protected function configPath()
    {
        return dirname(__DIR__) . '/config/rsa.php';
    }
}
