<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\About;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Work;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $about = About::first();
        $experiences = Experience::all();
        $educations = Education::all();
        $works = Work::all();
        $blogs = Blog::latest()->take(4)->get();
        return view('pages.home', compact('about' , 'experiences', 'educations', 'works', 'blogs'));
    }
}
