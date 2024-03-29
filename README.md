## Laravel RSA

### 安装

```shell
# 安装
$ composer require seffeng/laravel-rsa
```

##### Laravel

```php
# 1、生成配置文件
$ php artisan vendor:publish --tag="rsa"

# 2、生成key文件，多个客户端时可以指定client，对应配置文件中 clients 的配置，如：
# php artisan rsa:generate default
$ php artisan rsa:generate
```

##### lumen

```php
# 1、将以下代码段添加到 /bootstrap/app.php 文件中的 Providers 部分
$app->register(Seffeng\LaravelRSA\RSAServiceProvider::class);

# 2、生成key文件，多个客户端时可以指定client，对应配置文件中 clients 的配置，如：
# php artisan rsa:generate other-client
$ php artisan rsa:generate
```

```shell
# 服务端
# /storage 目录下对应 public key 提供给客户端用于加密和签名；
# 使用 private key 解密、验证签名；

# 客户端
# 接收其他服务端提供的 public key 替换 /storage 目录下对应 public key 用于加密和签名；
# 使用 public key 加密、签名
```

### 示例

```php

use Seffeng\LaravelRSA\Facades\RSA;
use Seffeng\LaravelRSA\Exceptions\RSAException;

class SiteController extends Controller
{
    public function test()
    {
        try {
            // 多个客户端使用其他配置时，对应配置文件中 clients 的配置
            // RSA::loadClient('other-client');

            $plaintext = '123456';
            // 加密
            $entext = RSA::encrypt($plaintext);
            // 解密
            $detext = RSA::decrypt($entext);

            // 使用其他key
            // RSA::loadKey('-----BEGIN PUBLIC KEY-----......');
            // RSA::loadKey('-----BEGIN PRIVATE KEY-----......');

            $message = 'a=aaa&b=bbb&c=ccc';
            // 签名
            $sign = RSA::sign($message);
            // 签名验证
            $verify = RSA::verify($message, $sign);

            var_dump(base64_encode($entext), $detext);
            var_dump(base64_encode($sign), $verify);
        } catch (RSAException $e) {
            var_dump($e->getMessage());
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
```

## 项目依赖

| 依赖             | 仓库地址                            | 备注 |
| :--------------- | :---------------------------------- | :--- |
| seffeng/cryptlib | https://github.com/seffeng/cryptlib | 无   |

### 备注

无

