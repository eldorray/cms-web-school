<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $school = app('currentSchool');
        
        $posts = Post::where('school_id', $school->id)
            ->where('is_published', true)
            ->with('category')
            ->latest('published_at')
            ->paginate(12);
        
        $categories = Category::where('school_id', $school->id)
            ->where('is_active', true)
            ->withCount('posts')
            ->get();
        
        return view('frontend.posts.index', compact('school', 'posts', 'categories'));
    }
    
    public function show(Post $post)
    {
        $school = app('currentSchool');
        
        abort_if($post->school_id !== $school->id || !$post->is_published, 404);
        
        // Increment view count
        $post->increment('view_count');
        
        // Related posts
        $relatedPosts = Post::where('school_id', $school->id)
            ->where('is_published', true)
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn($q) => $q->where('category_id', $post->category_id))
            ->latest('published_at')
            ->take(4)
            ->get();
        
        return view('frontend.posts.show', compact('school', 'post', 'relatedPosts'));
    }
    
    public function category(Category $category)
    {
        $school = app('currentSchool');
        
        abort_if($category->school_id !== $school->id, 404);
        
        $posts = Post::where('school_id', $school->id)
            ->where('is_published', true)
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);
        
        $categories = Category::where('school_id', $school->id)
            ->where('is_active', true)
            ->withCount('posts')
            ->get();
        
        return view('frontend.posts.index', compact('school', 'posts', 'categories', 'category'));
    }
}
