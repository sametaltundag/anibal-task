<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($articles, 200);
    }

    public function store(ArticleRequest $request)
    {
        if(!$request->validated()){
            return response()->json(['errors' => $request->errors()], 422);
        }

        $category = Category::where('id',$request->category_id)->first();

        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image ?? null,
            'category_id' => $category->id,
            'category_slug' => $category->slug,
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'data' => $article,
            'message' => 'Blog oluşturuldu.'
        ],200);
    }


    public function show(string $slug)
    {
        // Eğer bulursa veri $article değişkenine atanır, bulunamazsa 404 hatası verir ver alt satıra geçmeden kod sonlandırılır.
        $article = Article::where('slug',$slug)->where('status',true)->first();


        // Blog aktif değil ise hata mesajı verip kod return ile Early Return akışı ile aşağı geçmeden sonlanır
        if(!$article || !$article->status){
            return response()->json([
                'message' => 'Blog yazısı bulunamadı'
            ],404);
        }

        // Üstteki aktiflik sorgulaması TRUE ile geçilirse veri gönderilir.
        return response()->json($article,200);
    }


    public function edit(string $id)
    {
        $article = Article::findOrFail($id);

        if(!$article->status){
            return response()->json([
                'message' => 'Blog yazısı bulunamadı'
            ],404);
        }
        return response()->json($article,200);
    }


    public function update(ArticleUpdateRequest $request, string $id)
    {
        $article = Article::findOrFail($id);

        if(!$article->status){
            return response()->json([
                'message' => 'Blog yazısı bulunamadı'
            ],404);
        }

        if(!$request->validated()){
            return response()->json(['errors' => $request->errors()], 422);
        }

        $category = Category::where('id',$request->category_id)->first();


        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image ?? null,
            'category_id' => $category->id,
            'category_slug' => $category->slug,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Blog yazısı güncellendi.',
            'data' => $article
        ],200);
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
            'message' => 'Blog yazısı silindi.'
        ],200);
    }

    public function category($category_slug){
        $category = Category::where('slug',$category_slug)->first();

        if(!$category){
            return response()->json([
                'message' => 'Kategori bulunamadı'
            ],404);
        }

        $articles = Article::where('status',true)
        ->where('category_slug', $category->slug)
        ->orderBy('created_at','desc')
        ->get();

        return response()->json($articles,200);
    }

    public function search($search){
        $articles = Article::where('status', true)
            ->where(function($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%')
                      ->orWhere('slug', 'like', '%'.$search.'%')
                      ->orWhere('content', 'like', '%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($articles, 200);
    }



}
