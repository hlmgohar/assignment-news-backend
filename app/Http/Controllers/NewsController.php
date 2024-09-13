<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $client = new Client();
        $apiKey = '200db4c6fb7f463c939c38a9e88651be'; // Replace with your NewsAPI key

        $response = $client->get('https://newsapi.org/v2/top-headlines', [
            'query' => [
                'country' => 'us',
                'apiKey' => $apiKey,
                'q' => $request->input('query', ''),
            ],
        ]);

        $news = json_decode($response->getBody()->getContents(), true);

        return response()->json($news);
    }
}