<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $categories = ArticleCategory::withCount(['articles' => function($q) {
            $q->where('is_published', true);
        }])->get();

        $recentArticles = Article::where('is_published', true)
            ->latest()
            ->take(5)
            ->get();

        return view('saas.knowledge_base.index', compact('categories', 'recentArticles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
            
        // Increment view count
        $article->increment('view_count');

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->take(5)
            ->get();

        return view('saas.knowledge_base.show', compact('article', 'relatedArticles'));
    }
    
    public function category($slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        $articles = $category->articles()->where('is_published', true)->paginate(10);
        
        return view('saas.knowledge_base.category', compact('category', 'articles'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $articles = Article::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->paginate(10);
            
        return view('saas.knowledge_base.search', compact('articles', 'query'));
    }
}
