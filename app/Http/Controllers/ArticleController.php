<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;

class ArticleController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|array',
            'title.en' => 'required|string|min:6',
            'title.ar' => 'required|string|min:6',
            'content' => 'required|array',
            'content.en' => 'required|min:12',
            'content.ar' => 'required|min:12'
        ]);

        $article = new Article;
        $article->title = json_encode($request->title);
        $article->content = json_encode($request->content);
        $article->user_id = Auth::id();
        $article->save();

        return response()->json(['message' => 'Article created successfully']);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|array',
            'title.en' => 'required|string|min:6',
            'title.ar' => 'required|string|min:6',
            'content' => 'required|array',
            'content.en' => 'required|min:12',
            'content.ar' => 'required|min:12'
        ]);

        $article = Article::findOrFail($id);
        $article->title = json_encode($request->title);
        $article->content = json_encode($request->content);
        $article->user_id = Auth::id();
        $article->save();

        return response()->json(['message' => 'Article updated successfully']);
    }

    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        return response()->json(['message' => 'Article deleted successfully']);
    }

    public function profile_with_articles($locale = null)
    {
        if (isset($locale) && in_array($locale, config('locales.available_locales'))) {
            app()->setLocale($locale);
        }
        return response()->json(['errors' => false, 'results' => new ProfileResource(Auth::user())]);
    }
}
