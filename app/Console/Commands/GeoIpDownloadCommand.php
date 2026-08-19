<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class GeoIpDownloadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geoip:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and extract the MaxMind GeoLite2 City database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $config = config('geoip.maxmind');
        $url = $config['download_url'];
        $accountId = $config['account_id'];
        $licenseKey = $config['license_key'];

        if (! $accountId || ! $licenseKey) {
            $this->error('MaxMind Account ID and License Key are required. Check your config/geoip.php and .env file.');

            return 1;
        }

        $hashUrl = $url.'.sha256';
        $tempPath = storage_path('app/geoip_temp');

        if (File::exists($tempPath)) {
            File::deleteDirectory($tempPath);
        }
        File::makeDirectory($tempPath, 0755, true);

        $tarPath = $tempPath.'/GeoLite2-City.tar.gz';
        $shaPath = $tempPath.'/GeoLite2-City.tar.gz.sha256';

        $this->info('Downloading MaxMind database...');

        try {
            $response = Http::timeout(300)
                ->withBasicAuth($accountId, $licenseKey)
                ->get($url);

            if ($response->failed()) {
                $this->error('Failed to download database: '.$response->status());

                return 1;
            }
            File::put($tarPath, $response->body());

            $this->info('Downloading checksum...');
            $hashResponse = Http::withBasicAuth($accountId, $licenseKey)
                ->get($hashUrl);

            if ($hashResponse->failed()) {
                $this->error('Failed to download checksum: '.$hashResponse->status());

                return 1;
            }
            File::put($shaPath, $hashResponse->body());

            $this->info('Verifying checksum...');
            $expectedHash = explode(' ', trim($hashResponse->body()))[0];
            $actualHash = hash_file('sha256', $tarPath);

            if ($expectedHash !== $actualHash) {
                $this->error('Checksum verification failed!');
                $this->error('Expected: '.$expectedHash);
                $this->error('Actual:   '.$actualHash);

                return 1;
            }

            $this->info('Extracting database...');
            // Using shell command for better reliability with .tar.gz
            $escapedTarPath = escapeshellarg($tarPath);
            $escapedTempPath = escapeshellarg($tempPath);
            exec("tar -xzf $escapedTarPath -C $escapedTempPath");

            // Find the .mmdb file in the extracted directory
            $files = File::allFiles($tempPath);
            $mmdbFile = null;
            foreach ($files as $file) {
                if ($file->getExtension() === 'mmdb') {
                    $mmdbFile = $file;
                    break;
                }
            }

            if (! $mmdbFile) {
                $this->error('Could not find .mmdb file in the archive.');

                return 1;
            }

            $destination = config('geoip.maxmind.database_path');
            File::ensureDirectoryExists(dirname($destination));
            File::move($mmdbFile->getRealPath(), $destination);

            $this->info('Cleaning up...');
            File::deleteDirectory($tempPath);

            $this->info('MaxMind database updated successfully at '.$destination);

            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: '.$e->getMessage());

            return 1;
        }
    }
}
