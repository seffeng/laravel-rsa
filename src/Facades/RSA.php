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
 * @method static \Seffeng\LaravelRSA\RSA createKey(int $bits = 1024, $timeout = false, $partial = [])
 * @method static \Seffeng\LaravelRSA\RSA loadKey(string $key, int $type = null)
 * @method static \Seffeng\LaravelRSA\RSA encrypt($plaintext)
 * @method static \Seffeng\LaravelRSA\RSA decrypt($ciphertext)
 * @method static \Seffeng\LaravelRSA\RSA sign(string $message)
 * @method static \Seffeng\LaravelRSA\RSA verify(string $message, string $signature)
 * @method static \Seffeng\LaravelRSA\RSA setPublicKey(string $publicKey = null)
 * @method static \Seffeng\LaravelRSA\RSA setPublicKeyFormat($format)
 * @method static \Seffeng\LaravelRSA\RSA getPublicKey()
 * @method static \Seffeng\LaravelRSA\RSA setPrivateKey(string $privateKey = null)
 * @method static \Seffeng\LaravelRSA\RSA setPrivateKeyFormat($format)
 * @method static \Seffeng\LaravelRSA\RSA getPrivateKey()
 * @method static \Seffeng\LaravelRSA\RSA setComment(string $comment)
 * @method static \Seffeng\LaravelRSA\RSA getComment()
 * @method static \Seffeng\LaravelRSA\RSA setEncryptionMode(int $mode)
 * @method static \Seffeng\LaravelRSA\RSA setSignatureMode(int $mode)
 * @method static \Seffeng\LaravelRSA\RSA setHash(string $hash)
 * @method static \Seffeng\LaravelRSA\RSA setMGFHash(string $hash)
 * @method static \Seffeng\LaravelRSA\RSA setPassword($password = false)
 * @method static \Seffeng\LaravelRSA\RSA setSaltLength(int $saltLength)
 * @method static \Seffeng\LaravelRSA\RSA getPublicKeyFingerprint($algorithm = 'md5')
 * @method static \Seffeng\LaravelRSA\RSA getSize()
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