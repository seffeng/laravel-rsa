<?php
/**
 * @link http://github.com/seffeng/
 * @copyright Copyright (c) 2020 seffeng
 */
namespace Seffeng\LaravelRSA;

use Seffeng\LaravelRSA\Helpers\ArrayHelper;
use Seffeng\Cryptlib\Crypt as CryptRSA;
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
     * @var integer
     */
    protected $encryptionMode;

    /**
     *
     * @var integer
     */
    protected $signatureMode;

    /**
     *
     * @var string
     */
    protected $client;

    /**
     *
     * @var array
     */
    protected $config;

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param  array $config
     * @throws \RuntimeException
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $client = ArrayHelper::getValue($this->config, 'client');
        $this->loadClient($client);
    }

    /**
     *
     * @author zxf
     * @date   2021年8月3日
     * @param string $client
     */
    public function loadClient(string $client)
    {
        $this->setClient($client);
        $this->loadConfig();
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param  integer $bits
     * @param  integer $timeout
     * @param  array $partial
     * @return array
     */
    public function createKey(int $bits = 1024, $timeout = false, $partial = [])
    {
        try {
            return $this->cryptRSA->createKey($bits, $timeout, $partial);
        } catch (\Exception $e) {
            throw new RSAException($e->getMessage());
        }
    }

    /**
     *
     * @author zxf
     * @date    2020年6月22日
     * @param  string $key
     * @param  integer $type
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function loadKey(string $key, int $type = null)
    {
        try {
            $this->cryptRSA->loadKey($key, $type);
            $this->setPublicKey($this->cryptRSA->getPublicKey());
            $this->setPrivateKey($this->cryptRSA->getPrivateKey());
            return $this;
        } catch (\Exception $e) {
            throw new RSAException($e->getMessage());
        }
    }

    /**
     *
     * @author zxf
     * @date   2020年5月20日
     * @param string $plaintext
     * @return string
     */
    public function encrypt($plaintext)
    {
        try {
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
     * @return string
     */
    public function decrypt($ciphertext)
    {
        try {
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
     * @throws RSAException
     * @return string
     */
    public function sign(string $message)
    {
        try {
            $this->cryptRSA->loadKey($this->privateKey);
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
     * @throws RSAException
     * @return boolean
     */
    public function verify(string $message, string $signature)
    {
        try {
            $this->cryptRSA->loadKey($this->publicKey);
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
            if (file_exists($this->publicKeyFile)) {
                $publicKey = file_get_contents($this->publicKeyFile);
            }
        }
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  integer $format
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setPublicKeyFormat($format)
    {
        $this->cryptRSA->setPublicKeyFormat($format);
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
            if (file_exists($this->privateKeyFile)) {
                $privateKey = file_get_contents($this->privateKeyFile);
            }
        }

        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  integer $format
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setPrivateKeyFormat($format)
    {
        $this->cryptRSA->setPrivateKeyFormat($format);
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

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param string $comment
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setComment(string $comment)
    {
        $this->cryptRSA->setComment($comment);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @return string
     */
    public function getComment()
    {
        return $this->cryptRSA->getComment();
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  integer $mode
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setEncryptionMode(int $mode)
    {
        $this->encryptionMode = $mode;
        $this->cryptRSA->setEncryptionMode($this->encryptionMode);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  integer $mode
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setSignatureMode(int $mode)
    {
        $this->signatureMode = $mode;
        $this->cryptRSA->setSignatureMode($this->signatureMode);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  string $hash
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setHash(string $hash)
    {
        $this->cryptRSA->setHash($hash);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  string $hash
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setMGFHash(string $hash)
    {
        $this->cryptRSA->setMGFHash($hash);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  string $password
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setPassword($password = false)
    {
        $this->cryptRSA->setPassword($password);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  integer $saltLength
     * @return \Seffeng\LaravelRSA\RSA
     */
    public function setSaltLength(int $saltLength)
    {
        $this->cryptRSA->setSaltLength($saltLength);
        return $this;
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @param  string $algorithm string $algorithm The hashing algorithm to be used. Valid options are 'md5' and 'sha256'. False is returned for invalid values.
     * @return mixed|boolean|string
     */
    public function getPublicKeyFingerprint($algorithm = 'md5')
    {
        return $this->cryptRSA->getPublicKeyFingerprint($algorithm);
    }

    /**
     *
     * @author zxf
     * @date    2020年5月26日
     * @return integer
     */
    public function getSize()
    {
        return $this->cryptRSA->getSize();
    }

    /**
     *
     * @author zxf
     * @date   2021年8月3日
     * @param string $client
     * @return static
     */
    protected function setClient(string $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     *
     * @author zxf
     * @date   2021年8月3日
     * @return string
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     *
     * @author zxf
     * @date   2021年8月3日
     * @throws RSAException
     */
    protected function loadConfig()
    {
        $client = ArrayHelper::getValue($this->config, 'clients.' . $this->getClient());
        if ($client) {
            $privateName = ArrayHelper::getValue($client, 'private');
            $publicName = ArrayHelper::getValue($client, 'public');
            $this->encryptionMode = ArrayHelper::getValue($client, 'encryptionMode');
            $this->signatureMode = ArrayHelper::getValue($client, 'signatureMode');

            if (is_null($privateName) || is_null($publicName)) {
                throw new RSAException('Warning: privateKey file, publicKey file cannot be empty.');
            }

            $this->privateKeyFile = storage_path($privateName);
            $this->publicKeyFile = storage_path($publicName);
            $this->cryptRSA = new CryptRSA();
            $this->setPublicKey();
            $this->setPrivateKey();
            is_numeric($this->encryptionMode) && $this->setEncryptionMode($this->encryptionMode);
            is_numeric($this->signatureMode) && $this->setSignatureMode($this->signatureMode);
        } else {
            throw new RSAException('The client['. $this->getClient() .'] is not found.');
        }
    }
}
