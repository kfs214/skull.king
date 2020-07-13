<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Encryption\Encrypter;

class SaltGenerateCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salt:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate salt for hashids and write it on .env';

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
      $key1 = $this->generateRandomKey();
      $key2 = $this->generateRandomKey();

      // Next, we will replace the application key in the environment file so it is
      // automatically setup for this developer. This key gets generated using a
      // secure random byte generator and is later base64 encoded for storage.
      if (! $this->setKeyInEnvironmentFile($key1, $key2)) {
          return;
      }

      $this->laravel['config']['hashids.connections.master.salt'] = $key1;
      $this->laravel['config']['hashids.connections.player.salt'] = $key2;

      $this->info('Salt set successfully.');
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey($this->laravel['config']['app.cipher'])
        );
    }

    /**
     * Set the application key in the environment file.
     *
     * @param  string  $key
     * @return bool
     */
    protected function setKeyInEnvironmentFile($key1, $key2)
    {
        $currentKey1 = $this->laravel['config']['hashids.connections.master.salt'];
        $currentKey2 = $this->laravel['config']['hashids.connections.player.salt'];

        if (strlen($currentKey1) !== 0 && strlen($currentKey2) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($key1, $key2);

        return true;
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param  string  $key
     * @return void
     */
    protected function writeNewEnvironmentFileWith($key1, $key2)
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->keyReplacementPattern('master'),
            'HASHIDS_SALT_MASTER='.$key1,
            file_get_contents($this->laravel->environmentFilePath())
        ));

        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->keyReplacementPattern('player'),
            'HASHIDS_SALT_PLAYER='.$key2,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern($mode)
    {
        if($mode == 'master'){
          $escaped = preg_quote('='.$this->laravel['config']['hashids.connections.master.salt'], '/');
          return "/^HASHIDS_SALT_MASTER{$escaped}/m";

        }elseif($mode == 'player'){
          $escaped = preg_quote('='.$this->laravel['config']['hashids.connections.player.salt'], '/');
          return "/^HASHIDS_SALT_PLAYER{$escaped}/m";
        }
    }
}
