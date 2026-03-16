<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function edit()
    {
        $home = HomeSetting::getInstance();
        return view('admin.pages.home.edit', compact('home'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_heading'    => 'nullable|string|max:500',
            'hero_image'      => 'nullable|url|max:2000',
            'feature_heading' => 'nullable|string|max:500',
            'feature_text'    => 'nullable|string|max:2000',
            'feature_image'   => 'nullable|url|max:2000',
        ]);

        HomeSetting::getInstance()->update($data);

        return redirect()->route('admin.home.edit')->with('success', 'Home page updated ♡');
    }
}
