<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Tag;

class GalleryPageController extends Controller
{
    public function index()
    {
        $items = GalleryItem::query()
            ->where('is_active', true)
            ->with('tags:id,name')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $tags = Tag::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('pages.gallery', compact('items', 'tags'));
    }
}
