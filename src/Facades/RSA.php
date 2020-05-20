<?php
/**
 * @link http://github.com/seffeng/
 * @copyright Copyright (c) 2020 seffeng
 */
namespace Seffeng\LaravelRSA\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @author zxf
 * @date    2020年5月20日
 * @method static \Seffeng\LaravelRSA\RSA createKey(int $bits = 1024, int $timeout = false, $partial = [])
 * @method static \Seffeng\LaravelRSA\RSA encrypt($plaintext, string $publicKey = null)
 * @method static \Seffeng\LaravelRSA\RSA decrypt($ciphertext, string $private = null)
 *
 * @see \Seffeng\LaravelRSA\RSA
 */
class RSA extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'seffeng.laravel.rsa';
    }
}