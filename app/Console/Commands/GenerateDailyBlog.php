<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BlogAutomationService;

class GenerateDailyBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:generate-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and publish a daily SEO CPNS blog article with an automated branded cover image';

    /**
     * Execute the console command.
     */
    public function handle(BlogAutomationService $blogService)
    {
        $this->info("🚀 Memulai proses pembuatan artikel blog otomatis CalonASN...");

        try {
            $post = $blogService->generateDailyPost();

            $this->newLine();
            $this->info("✅ ARTIKEL BERHASIL DITERBITKAN!");
            $this->table(
                ['Parameter', 'Nilai'],
                [
                    ['Judul', $post->title],
                    ['Kategori', $post->category->name ?? '-'],
                    ['Slug', $post->slug],
                    ['Gambar Sampul', $post->image_url],
                    ['Status', strtoupper($post->status)],
                    ['URL Artikel', url("/blog/{$post->slug}")],
                    ['Waktu Publish', $post->published_at->format('d M Y, H:i:s')],
                ]
            );

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("❌ Terjadi kegagalan: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
