<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function edit()
    {
        $about = AboutSetting::getInstance();
        return view('admin.pages.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_heading' => 'nullable|string|max:500',
            'hero_tagline' => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'image_url'    => 'nullable|url|max:2000',
        ]);

        $about = AboutSetting::getInstance();
        $about->update($data);

        return redirect()
            ->route('admin.about.edit')
            ->with('success', 'About page updated ♡');
    }
}
