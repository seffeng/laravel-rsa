<?php
/**
 * @link http://github.com/seffeng/
 * @copyright Copyright (c) 2020 seffeng
 */
namespace Seffeng\LaravelRSA\Console;

use Illuminate\Console\Command;
use Seffeng\LaravelRSA\Facades\RSA;
use Seffeng\LaravelRSA\Helpers\ArrayHelper;
use Seffeng\LaravelRSA\Exceptions\RSAException;

class RSAGenerateKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rsa:generate {client? : rsa配置文件中的clients项}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RSA GENERATE KEY';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = $this->argument('client');
        is_null($client) && $client = config('rsa.client');
        $publicKeyPath = config('rsa.clients.'. $client . '.public');
        $privateKeyPath = config('rsa.clients.'. $client . '.private');
        if ($publicKeyPath && $privateKeyPath) {
            $exist = false;
            if (file_exists(storage_path($privateKeyPath))) {
                if ($this->ask('The file is exists. Are you sure you want to override it?[y/n]') === 'y') {
                    $exist = true;
                } else {
                    return $this->warn('Canceled! No changes were made to your rsa key.');
                }
            }
            $keys = RSA::createKey();
            $publicKey = ArrayHelper::getValue($keys, 'publicKey');
            $privateKey = ArrayHelper::getValue($keys, 'privateKey');
            file_put_contents(storage_path($privateKeyPath), $privateKey);
            file_put_contents(storage_path($publicKeyPath), $publicKey);

            if (file_exists(storage_path($privateKeyPath))) {
                if ($exist) {
                    return $this->warn('rsa key ['. storage_path($privateKeyPath) .'] override successfully.');
                }
                return $this->info('rsa key ['. storage_path($privateKeyPath) .'] set successfully.');
            }
        }
        throw new RSAException('Please set client\'s RSA_PRIVATE_KEY and RSA_PUBLIC_KEY.');
    }
}
