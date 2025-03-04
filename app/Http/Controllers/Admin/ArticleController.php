<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ArticleStoreRequest;
use App\Http\Requests\Admin\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $articles = Article::with('categories')->latest()->paginate(10);
            return view('admin.articles.index', compact('articles'));
        } catch (Exception $e) {
            Log::error('Error displaying articles in admin panel: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return redirect()->route('admin.dashboard')
                ->with('error', 'There was a problem loading the articles. Please try again later.');
        }
    }

    /**
     * Show the form for creating a new article.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.articles.create', compact('categories'));
        } catch (Exception $e) {
            Log::error('Error displaying article creation form: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return redirect()->route('admin.articles.index')
                ->with('error', 'There was a problem loading the article creation form. Please try again later.');
        }
    }

    /**
     * Store a newly created article in storage.
     *
     * @param  \App\Http\Requests\Admin\ArticleStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $article = Article::create([
                    'title' => $request->title,
                    'body' => $request->body,
                ]);

                $article->categories()->attach($request->categories);

                return redirect()->route('admin.articles.index')
                    ->with('success', 'Article created successfully.');
            });
        } catch (Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->except('_token')
            ]);
            
            return redirect()->route('admin.articles.create')
                ->with('error', 'There was a problem creating the article. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        try {
            $categories = Category::all();
            $selectedCategories = $article->categories->pluck('id')->toArray();
            
            return view('admin.articles.edit', compact('article', 'categories', 'selectedCategories'));
        } catch (Exception $e) {
            Log::error('Error displaying article edit form: ' . $e->getMessage(), [
                'exception' => $e,
                'article_id' => $article->id
            ]);
            
            return redirect()->route('admin.articles.index')
                ->with('error', 'There was a problem loading the article edit form. Please try again later.');
        }
    }

    /**
     * Update the specified article in storage.
     *
     * @param  \App\Http\Requests\Admin\ArticleUpdateRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        try {
            return DB::transaction(function () use ($request, $article) {
                $article->update([
                    'title' => $request->title,
                    'body' => $request->body,
                ]);

                $article->categories()->sync($request->categories);

                return redirect()->route('admin.articles.index')
                    ->with('success', 'Article updated successfully.');
            });
        } catch (Exception $e) {
            Log::error('Error updating article: ' . $e->getMessage(), [
                'exception' => $e,
                'article_id' => $article->id,
                'request_data' => $request->except('_token')
            ]);
            
            return redirect()->route('admin.articles.edit', $article)
                ->with('error', 'There was a problem updating the article. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Remove the specified article from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            return DB::transaction(function () use ($article) {
                // Delete related recommendations and interactions first
                $article->recommendations()->delete();
                $article->interactions()->delete();
                
                // Then delete the article
                $article->delete();

                return redirect()->route('admin.articles.index')
                    ->with('success', 'Article deleted successfully.');
            });
        } catch (Exception $e) {
            Log::error('Error deleting article: ' . $e->getMessage(), [
                'exception' => $e,
                'article_id' => $article->id
            ]);
            
            return redirect()->route('admin.articles.index')
                ->with('error', 'There was a problem deleting the article. Please try again later.');
        }
    }
} 