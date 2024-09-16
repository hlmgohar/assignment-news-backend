<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SearchSportsArticles extends Command
{
    protected $signature = 'articles:search-sports';

    protected $description = 'Search and save sports articles from NewsAPI using category';

    public function handle(): void
    {
        $apiUrl = 'https://newsapi.org/v2/top-headlines';
        $apiKey = '200db4c6fb7f463c939c38a9e88651be';

        // Fetch articles using the "sports" category
        $response = Http::get($apiUrl, [
            'category' => 'sports',  // Specify the category here
            'country' => 'us',       // Optionally filter by country
            'apiKey' => $apiKey,
        ]);

        if ($response->successful()) {
            $articles = $response->json('articles');

            foreach ($articles as $articleData) {
                Article::updateOrCreate(
                    [
                        'url' => $articleData['url'],
                    ],
                    [
                        'author' => $articleData['author'],
                        'title' => $articleData['title'],
                        'description' => $articleData['description'],
                        'urlToImage' => $articleData['urlToImage'],
                        'publishedAt' => $articleData['publishedAt'],
                        'content' => $articleData['content'],
                    ]
                );
            }

            $this->info('Sports articles fetched and saved successfully.');
        } else {
            $this->error('Failed to fetch sports articles.');
        }
    }
}
