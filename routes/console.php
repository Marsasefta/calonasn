<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Jadwal Publikasi Artikel Blog Otomatis Harian CalonASN (Setiap jam 06:00 Pagi)
Schedule::command('blog:generate-daily')
    ->dailyAt('06:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/blog-automation.log'));

