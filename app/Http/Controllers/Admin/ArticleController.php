<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->latest()->get();
        return view('admin.knowledge_base.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = ArticleCategory::all();
        return view('admin.knowledge_base.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:article_categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($request->title);
        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'content' => $request->input('content'),
            'thumbnail' => $thumbnailPath,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function edit(Article $article)
    {
        $categories = ArticleCategory::all();
        return view('admin.knowledge_base.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:article_categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'category_id' => $request->category_id,
            'content' => $request->input('content'),
            'is_published' => $request->has('is_published'),
        ];

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
