<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class GalleryController extends Controller
{
    public function index()
    {
        $items = GalleryItem::with('tags')->orderBy('sort_order')->orderBy('id', 'desc')->get();
        return view('admin.pages.gallery.index', compact('items'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.pages.gallery.create', compact('tags'));
    }

public function store(Request $request)
{
    $data = $request->validate([
        'title'     => ['nullable', 'string', 'max:255'],
        'caption'   => ['nullable', 'string'],
        'image_url' => ['required', 'url', 'max:2000'],
        'tags_csv'  => ['nullable', 'string', 'max:1000'],
        'is_active' => ['nullable', 'boolean'],
    ]);
    $data['is_active'] = (bool)($data['is_active'] ?? false);

    $item = GalleryItem::create([
        'title'      => $data['title'] ?? null,
        'caption'    => $data['caption'] ?? null,
        'image_url'  => $data['image_url'],
        'is_active'  => $data['is_active'],
        'sort_order' => (GalleryItem::max('sort_order') ?? 0) + 1,
        // keep this if column exists; otherwise remove:
        'cloudinary_public_id' => null,
    ]);

    $tags = collect(explode(',', $data['tags_csv'] ?? ''))
        ->map(fn ($t) => trim($t))
        ->filter()
        ->unique()
        ->values()
        ->all();

    $this->syncTags($item, $tags);

    return redirect()
        ->route('admin.gallery.index')
        ->with('success', 'Gallery item added ♡');
}


public function show(GalleryItem $gallery)
{
    $gallery->load('tags');
    return view('admin.pages.gallery.show', compact('gallery'));
}

public function edit(GalleryItem $gallery)
{
    $gallery->load('tags');
    $tags = Tag::orderBy('name')->get();
    return view('admin.pages.gallery.edit', compact('gallery', 'tags'));
}


public function update(Request $request, GalleryItem $gallery)
{
    $data = $request->validate([
        'title'     => ['nullable', 'string', 'max:255'],
        'caption'   => ['nullable', 'string'],
        'image_url' => ['required', 'url', 'max:2000'],
        'tags_csv'  => ['nullable', 'string', 'max:1000'],
        'is_active' => ['nullable', 'boolean'],
    ]);

    $data['is_active'] = (bool)($data['is_active'] ?? false);

    $gallery->update([
        'title'     => $data['title'] ?? null,
        'caption'   => $data['caption'] ?? null,
        'image_url' => $data['image_url'],
        'is_active' => $data['is_active'],
        'cloudinary_public_id' => null, // optional
    ]);

    $tags = collect(explode(',', $data['tags_csv'] ?? ''))
        ->map(fn ($t) => trim($t))
        ->filter()
        ->unique()
        ->values()
        ->all();

    $this->syncTags($gallery, $tags);

    return redirect()
        ->route('admin.gallery.index')
        ->with('success', 'Gallery item updated ♡');
}

    public function destroy(GalleryItem $gallery)
    {
        $gallery->tags()->detach();
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted');
    }

    private function syncTags(GalleryItem $item, array $tagNames): void
    {
        $tagNames = collect($tagNames)
            ->map(fn($t) => trim($t))
            ->filter()
            ->unique()
            ->values();

        $tagIds = [];

        foreach ($tagNames as $name) {
            $slug = Str::slug($name);

            $tag = Tag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'slug' => $slug]
            );

            $tagIds[] = $tag->id;
        }

        $item->tags()->sync($tagIds);
    }
}
