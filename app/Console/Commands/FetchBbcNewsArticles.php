<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use Carbon\Carbon;

class FetchBbcNewsArticles extends Command
{
    protected $signature = 'fetch:bbc-news-articles';
    protected $description = 'Fetch news articles from the BBC News API and save them to the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Fetching BBC news articles...');

        // Replace with your actual BBC API URL and key if necessary
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => '200db4c6fb7f463c939c38a9e88651be', // Use your API key here
            'sources' => 'bbc-news' // Source parameter for BBC News
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];

            foreach ($articles as $item) {
                Article::updateOrCreate(
                    ['url' => $item['url']], // Unique constraint to avoid duplicates
                    [
                        'author'      => $item['author'] ?? null,
                        'title'       => $item['title'],
                        'description' => $item['description'] ?? null,
                        'urlToImage'  => $item['urlToImage'] ?? null,
                        'publishedAt' => isset($item['publishedAt']) ? Carbon::parse($item['publishedAt'])->toDateTimeString() : null,
                        'content'     => $item['content'] ?? null,
                    ]
                );
            }

            $this->info('BBC news articles successfully fetched and saved.');
        } else {
            $this->error('Failed to fetch BBC news articles. Status: ' . $response->status());
        }
    }
}
