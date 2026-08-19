<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Laravel\Pennant\Feature;
use Symfony\Component\Console\Command\Command as CommandAlias;

#[Signature('pennant:toggle {features* : The names of the features to toggle} {--off : Disable the features instead of enabling them}')]
#[Description('Toggle Pennant features globally in the database')]
class ToggleFeatureCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $featureNames = $this->argument('features');
        $off = $this->option('off');
        $definedFeatures = config('pennant.features', []);

        foreach ($featureNames as $name) {
            if (! in_array($name, $definedFeatures)) {
                $this->error("Feature [$name] is not defined in config/pennant.php.");

                continue;
            }

            if ($off) {
                Feature::forget($name);
                $this->info("Feature [$name] deactivated globally (reset to default logic).");
            } else {
                Feature::activate($name);
                $this->info("Feature [$name] activated globally.");
            }
        }

        return CommandAlias::SUCCESS;
    }
}
