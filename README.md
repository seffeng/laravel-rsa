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

# 2、生成key文件
$ php artisan rsa:generate
```

##### lumen

```php
# 1、将以下代码段添加到 /bootstrap/app.php 文件中的 Providers 部分
$app->register(Seffeng\LaravelRSA\RSAServiceProvider::class);

# 2、生成key文件
$ php artisan rsa:generate
```

```shell
# /storage 目录下对应 public key 提供给客户端
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
            $plaintext = '123456';
            // 加密
            $entext = RSA::encrypt($plaintext);
            // 解密
            $detext = RSA::decrypt($entext);

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

