<?php
/**
 * @link http://github.com/seffeng/
 * @copyright Copyright (c) 2020 seffeng
 */
namespace Seffeng\LaravelRSA;

use Seffeng\LaravelRSA\Helpers\ArrayHelper;
use phpseclib\Crypt\RSA as CryptRSA;
use Seffeng\LaravelRSA\Exceptions\RSAException;

class RSA
{
    /**
     *
     * @var CryptRSA
     */
    protected $cryptRSA;

    /**
     *
     * @var string
     */
    protected $privateKey;

    /**
     *
     * @var string
     */
    protected $privateKeyFile;

    /**
     *
     * @var string
     */
    protected $publicKey;

    /**
     *
     * @var string
     */
    protected $publicKeyFile;

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param  array $config
     * @throws \RuntimeException
     */
    public function __construct(array $config)
    {
        $privateName = ArrayHelper::getValue($config, 'keys.private');
        $publicName = ArrayHelper::getValue($config, 'keys.public');
        $encryptionMode = ArrayHelper::getValue($config, 'ENCRYPTION_MODE');

        if (is_null($privateName) || is_null($publicName)) {
            throw new RSAException('Warning: privateKey file, publicKey file cannot be empty.');
        }

        $this->privateKeyFile = storage_path($privateName);
        $this->publicKeyFile = storage_path($publicName);
        $this->cryptRSA = new CryptRSA();
        $this->cryptRSA->setEncryptionMode($encryptionMode);
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param  int $bits
     * @param  int $timeout
     * @param  array $partial
     * @return array
     */
    public function createKey(int $bits = 1024, $timeout = false, $partial = [])
    {
        return $this->cryptRSA->createKey($bits, $timeout, $partial);
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param string $plaintext
     * @return string
     */
    public function encrypt($plaintext, string $publicKey = null)
    {
        try {
            $this->setPublicKey($publicKey);
            $this->cryptRSA->loadKey($this->publicKey);
            return $this->cryptRSA->encrypt($plaintext);
        } catch (\Exception $e) {
            throw new RSAException($e->getMessage() .' or invalid key.');
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param string $ciphertext
     * @param string $privateKey
     * @return string
     */
    public function decrypt($ciphertext, string $privateKey = null)
    {
        try {
            $this->setPrivateKey($privateKey);
            $this->cryptRSA->loadKey($this->privateKey);
            return $this->cryptRSA->decrypt($ciphertext);
        } catch (\Exception $e) {
            throw new RSAException($e->getMessage() .' or invalid key.');
        }
    }

    /**
     * @author zxf
     * @date   2020年5月24日
     * @param string $message
     * @param string $publicKey
     * @throws RSAException
     * @return string
     */
    public function sign(string $message, string $publicKey = null)
    {
        try {
            $this->setPublicKey($publicKey);
            $this->cryptRSA->loadKey($this->publicKey);
            return $this->cryptRSA->sign($message);
        } catch (\Exception $e) {
            throw new RSAException($e->getMessage() .' or invalid key.');
        }
    }

    /**
     * @author zxf
     * @date   2020年5月24日
     * @param  string $message
     * @param  string $signature
     * @param  string $privateKey
     * @throws RSAException
     * @return boolean
     */
    public function verify(string $message, string $signature, string $privateKey = null)
    {
        try {
            $this->setPrivateKey($privateKey);
            $this->cryptRSA->loadKey($this->privateKey);
            return $this->cryptRSA->verify($message, $signature);
        } catch (\Exception $e) {
            throw new RSAException($e->getMessage() .' or invalid key.');
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param string $publicKey
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setPublicKey(string $publicKey = null)
    {
        if (is_null($publicKey)) {
            if (!file_exists($this->publicKeyFile)) {
                throw new RSAException('Warning: publicKey file not found.');
            }
            $publicKey = file_get_contents($this->publicKeyFile);
        }
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param string $privateKey
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setPrivateKey(string $privateKey = null)
    {
        if (is_null($privateKey)) {
            if (!file_exists($this->privateKeyFile)) {
                throw new RSAException('Warning: privateKey file not found.');
            }
            $privateKey = file_get_contents($this->privateKeyFile);
        }

        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }
}
