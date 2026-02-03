<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramLink;
use Illuminate\Http\Request;

class InstagramLinkController extends Controller
{
    public function index()
    {
        $links = InstagramLink::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.pages.instagram-links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.pages.instagram-links.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'     => ['nullable', 'string', 'max:255'],
            'post_url'  => ['required', 'url', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // default active true if checkbox unchecked not sent
        $data['is_active'] = (bool)($data['is_active'] ?? false);

        // put newest at end
        $data['sort_order'] = (InstagramLink::max('sort_order') ?? 0) + 1;

        InstagramLink::create($data);

        return redirect()->route('admin.instagram-links.index')
            ->with('success', 'Instagram link added!');
    }

    public function show(InstagramLink $instagram_link)
    {
        return view('admin.pages.instagram-links.show', ['link' => $instagram_link]);
    }

    public function edit(InstagramLink $instagram_link)
    {
        return view('admin.pages.instagram-links.edit', ['link' => $instagram_link]);
    }

    public function update(Request $request, InstagramLink $instagram_link)
    {
        $data = $request->validate([
            'label'     => ['nullable', 'string', 'max:255'],
            'post_url'  => ['required', 'url', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? false);

        $instagram_link->update($data);

        return redirect()->route('admin.instagram-links.index')
            ->with('success', 'Instagram link updated!');
    }

    public function destroy(InstagramLink $instagram_link)
    {
        $instagram_link->delete();

        return redirect()->route('admin.instagram-links.index')
            ->with('success', 'Instagram link deleted!');
    }
}
