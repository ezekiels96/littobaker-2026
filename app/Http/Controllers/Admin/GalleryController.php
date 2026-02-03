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
            'title'    => ['nullable', 'string', 'max:255'],
            'caption'  => ['nullable', 'string'],
            'image'    => ['required', 'image', 'max:8192'], // 8MB
            'tags'     => ['nullable', 'array'],
            'tags.*'   => ['string', 'max:50'],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        // upload to Cloudinary
        $uploaded = Cloudinary::upload(
            $request->file('image')->getRealPath(),
            ['folder' => 'littobaker/gallery']
        );

        $imageUrl = $uploaded->getSecurePath();
        $publicId = $uploaded->getPublicId();

        $item = GalleryItem::create([
            'title' => $data['title'] ?? null,
            'caption' => $data['caption'] ?? null,
            'image_url' => $imageUrl,
            'cloudinary_public_id' => $publicId,
            'is_active' => $data['is_active'],
            'sort_order' => (GalleryItem::max('sort_order') ?? 0) + 1,
        ]);

        $this->syncTags($item, $data['tags'] ?? []);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added ♡');
    }

    public function show(GalleryItem $gallery)
    {
        $gallery->load('tags');
        return view('admin.pages.gallery.show', ['item' => $gallery]);
    }

    public function edit(GalleryItem $gallery)
    {
        $gallery->load('tags');
        $tags = Tag::orderBy('name')->get();
        return view('admin.pages.gallery.edit', ['item' => $gallery, 'tags' => $tags]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $data = $request->validate([
            'title'    => ['nullable', 'string', 'max:255'],
            'caption'  => ['nullable', 'string'],
            'image'    => ['nullable', 'image', 'max:8192'],
            'tags'     => ['nullable', 'array'],
            'tags.*'   => ['string', 'max:50'],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        // optional new upload
        if ($request->hasFile('image')) {
            $uploaded = Cloudinary::upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'littobaker/gallery']
            );

            $gallery->image_url = $uploaded->getSecurePath();
            $gallery->cloudinary_public_id = $uploaded->getPublicId();
        }

        $gallery->title = $data['title'] ?? null;
        $gallery->caption = $data['caption'] ?? null;
        $gallery->is_active = $data['is_active'];
        $gallery->save();

        $this->syncTags($gallery, $data['tags'] ?? []);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated ♡');
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
