<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Search articles by keyword or author.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Get the 'q' and 'author' query parameters
        $keyword = $request->query('q');
        $author = $request->query('author');

        // Build the query to filter articles
        $query = Article::query();

        if ($keyword) {
            // Search by title, description, and content fields
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'LIKE', "%$keyword%")
                  ->orWhere('description', 'LIKE', "%$keyword%")
                  ->orWhere('content', 'LIKE', "%$keyword%");
            });
        }

        if ($author) {
            // Search by author name
            $query->where('author', 'LIKE', "%$author%");
        }

        // Get the search results
        $articles = $query->get();

        // Return a JSON response with the found articles
        return response()->json([
            'status' => 'success',
            'totalResults' => $articles->count(),
            'articles' => $articles,
        ]);
    }
}
