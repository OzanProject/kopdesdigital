<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::latest()->get();
        return view('admin.knowledge_base.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.knowledge_base.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ArticleCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.article-categories.index')
            ->with('success', 'Kategori bantuan berhasil ditambahkan.');
    }

    public function edit(ArticleCategory $article_category)
    {
        return view('admin.knowledge_base.categories.edit', compact('article_category'));
    }

    public function update(Request $request, ArticleCategory $article_category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $article_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.article-categories.index')
            ->with('success', 'Kategori bantuan berhasil diperbarui.');
    }

    public function destroy(ArticleCategory $article_category)
    {
        $article_category->delete();
        return redirect()->route('admin.article-categories.index')
            ->with('success', 'Kategori bantuan berhasil dihapus.');
    }
}
