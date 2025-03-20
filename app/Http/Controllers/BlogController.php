<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController
{
    public function index()
    {
        $blogs = Blog::paginate(6);
        return view('pages.blog.index', compact('blogs'));
    }

    public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('pages.blog.details', compact('blog'));
    }

}
