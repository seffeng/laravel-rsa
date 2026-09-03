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
 * @method static \Seffeng\LaravelRSA\RSA loadClient(string $client)
 * @method static array createKey(int $bits = 1024, $timeout = false, $partial = [])
 * @method static \Seffeng\LaravelRSA\RSA loadKey(string $key, int $type = null)
 * @method static string encrypt($plaintext)
 * @method static string decrypt($ciphertext)
 * @method static string sign(string $message)
 * @method static bool verify(string $message, string $signature)
 * @method static \Seffeng\LaravelRSA\RSA setPublicKey(string $publicKey = null)
 * @method static \Seffeng\LaravelRSA\RSA setPublicKeyFormat($format)
 * @method static string getPublicKey()
 * @method static \Seffeng\LaravelRSA\RSA setPrivateKey(string $privateKey = null)
 * @method static \Seffeng\LaravelRSA\RSA setPrivateKeyFormat($format)
 * @method static string getPrivateKey()
 * @method static \Seffeng\LaravelRSA\RSA setComment(string $comment)
 * @method static string getComment()
 * @method static \Seffeng\LaravelRSA\RSA setEncryptionMode(int $mode)
 * @method static \Seffeng\LaravelRSA\RSA setSignatureMode(int $mode)
 * @method static \Seffeng\LaravelRSA\RSA setHash(string $hash)
 * @method static \Seffeng\LaravelRSA\RSA setMGFHash(string $hash)
 * @method static \Seffeng\LaravelRSA\RSA setPassword($password = false)
 * @method static \Seffeng\LaravelRSA\RSA setSaltLength(int $saltLength)
 * @method static mixed|bool|string getPublicKeyFingerprint($algorithm = 'md5')
 * @method static int getSize()
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