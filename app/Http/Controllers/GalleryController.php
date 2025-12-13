<?php

namespace App\Http\Controllers;

use App\Models\GalleryPost;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
   public function index()
{
    return GalleryPost::where('active', true)
        ->orderBy('created_at', 'desc')
        ->get();
}
}
