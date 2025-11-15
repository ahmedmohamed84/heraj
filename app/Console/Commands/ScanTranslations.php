<?php

namespace App\Console\Commands;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Finder;

class ScanTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan the application for translation keys and add them to the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Scanning for translation keys...');

        // 1. Fetch Active Locales
        try {
            $locales = Language::where('is_active', true)->pluck('code')->toArray();
        } catch (\Exception $e) {
            $this->error('Could not connect to the database or find the languages table.');
            $this->error('Please ensure your database is configured and migrations are run.');
            return 1;
        }

        if (empty($locales)) {
            $this->error('No active languages found in the database. Please add/activate languages first.');
            return 1;
        }
        $this->line('Active locales: <info>' . implode(', ', $locales) . '</info>');

        // 2. Scan Directories
        $scanPaths = [
            app_path(),
            resource_path('views'),
        ];
        $finder = new Finder();
        $finder->in($scanPaths)->name('*.php')->files();

        // 3. Regex Extraction
        $translationKeys = [];
        // Regex to find __(), trans(), and @lang() helpers in PHP and Blade files.
        $pattern = "/(?:__|trans|@lang)\(\s*['\"]([^'\"]+)['\"]\s*\)/";

        foreach ($finder as $file) {
            if (preg_match_all($pattern, $file->getContents(), $matches)) {
                foreach ($matches[1] as $key) {
                    // Ignore dynamic keys which contain variables
                    if (!str_contains($key, '$')) {
                        $translationKeys[] = $key;
                    }
                }
            }
        }

        $translationKeys = array_unique($translationKeys);
        $this->line('Found <info>' . count($translationKeys) . '</info> unique translation key strings.');

        if (empty($translationKeys)) {
            $this->info('Scan complete. No keys to process.');
            return 0;
        }

        // 4 & 5. Process Keys and Insert into Database
        $newKeysCount = 0;
        $progressBar = $this->output->createProgressBar(count($translationKeys));
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% -- Processing keys...');
        $progressBar->start();

        foreach ($translationKeys as $fullKey) {
            $group = null;
            $key = $fullKey;

            // Case A (Dot Notation): 'group.key'
            if (str_contains($fullKey, '.')) {
                $parts = explode('.', $fullKey, 2);
                $group = $parts[0];
                $key = $parts[1];
            }
            // Case B (JSON/String): 'Some string' is the default

            foreach ($locales as $locale) {
                $translation = Translation::firstOrCreate(
                    [
                        'locale' => $locale,
                        'group' => $group,
                        'key' => $key,
                    ],
                    [
                        // Set the value to the full key string by default for easy translation
                        'value' => $fullKey,
                    ]
                );

                if ($translation->wasRecentlyCreated) {
                    $newKeysCount++;
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\n");

        // Clear cache for all active locales to apply changes immediately
        foreach ($locales as $locale) {
            Cache::forget("translations_{$locale}");
        }
        $this->line('<info>Translation cache cleared for all active locales.</info>');

        // The number of new records created is $newKeysCount.
        // The number of unique keys added is $newKeysCount / number of locales.
        $actualNewKeys = $newKeysCount / (count($locales) ?: 1);

        if ($actualNewKeys > 0) {
            $this->info("Success! Added {$actualNewKeys} new unique keys to the database.");
        } else {
            $this->info("Scan complete. All found keys already exist in the database.");
        }

        return 0;
    }
}
