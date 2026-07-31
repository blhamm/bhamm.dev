<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Image;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;

#[Signature('images:convert-to-webp {--dir=public/images : The directory to scan for images} {--keep : Keep the original images} {--quality=80 : The quality of the converted WebP images}')]
#[Description('Convert all images in a directory to WebP format')]
class ConvertImagesToWebp extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dir = $this->option('dir');
        $directory = base_path($dir);
        $keepOriginals = $this->option('keep');
        $quality = (int) $this->option('quality');

        if (!File::isDirectory($directory)) {
            $this->error("Directory {$directory} does not exist.");
            return 1;
        }

        $files = File::allFiles($directory);
        $supportedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $convertedCount = 0;
        $skippedCount = 0;
        $errorCount = 0;
        $totalOriginalSize = 0;
        $totalConvertedSize = 0;

        $this->info("Scanning directory: {$dir}");

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());
            
            if (!in_array($extension, $supportedExtensions)) {
                $skippedCount++;
                continue;
            }

            $path = $file->getRealPath();
            $outputPath = preg_replace('/\.' . $extension . '$/i', '.webp', $path);

            $this->comment("Converting: {$file->getRelativePathname()}");

            try {
                $originalSize = File::size($path);
                
                $image = Image::fromPath($path)
                    ->toWebp()
                    ->quality($quality);
                
                $webpData = $image->toBytes();
                File::put($outputPath, $webpData);
                $convertedSize = strlen($webpData);

                $savings = $originalSize - $convertedSize;
                $savingsPercent = ($originalSize > 0) ? round(($savings / $originalSize) * 100, 2) : 0;

                if (!$keepOriginals) {
                    File::delete($path);
                    $this->line("  <info>✔</info> Converted: {$this->formatBytes($originalSize)} -> {$this->formatBytes($convertedSize)} (<info>-{$savingsPercent}%</info>)");
                } else {
                    $this->line("  <info>✔</info> Converted and kept original: {$this->formatBytes($originalSize)} -> {$this->formatBytes($convertedSize)} (<info>-{$savingsPercent}%</info>)");
                }
                
                $totalOriginalSize += $originalSize;
                $totalConvertedSize += $convertedSize;
                $convertedCount++;
            } catch (\Exception $e) {
                $this->error("  <error>✘</error> Failed to convert {$file->getFilename()}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->newLine();
        $this->info("Conversion Complete!");
        
        $totalSavings = $totalOriginalSize - $totalConvertedSize;
        $totalSavingsPercent = ($totalOriginalSize > 0) ? round(($totalSavings / $totalOriginalSize) * 100, 2) : 0;

        $this->table(
            ['Metric', 'Value'],
            [
                ['Converted', $convertedCount],
                ['Skipped', $skippedCount],
                ['Errors', $errorCount],
                ['Original Size', $this->formatBytes($totalOriginalSize)],
                ['Converted Size', $this->formatBytes($totalConvertedSize)],
                ['Total Savings', $this->formatBytes($totalSavings) . " (-{$totalSavingsPercent}%)"],
            ]
        );

        return 0;
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
