<?php
namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\MenuImage;
use App\Models\Variation;
use App\Models\AddOn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['images'])->orderBy('sort_order')->get();
        
        return view('admin.pages.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.pages.menu.create');
    }

public function store(Request $request)
{
    $data = $request->validate([
        'name'          => 'required|string|max:255',
        'title'         => 'required|string|max:255',
        'description'   => 'nullable|string',
        'price'         => 'required|numeric',
        'quantity_type' => 'required|string',
        'image_urls'    => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($data) {
            $nextSort = \App\Models\Menu::max('sort_order') + 1;

            // Create the menu (only DB columns)
            $menu = Menu::create([
                'name'          => $data['name'],
                'title'         => $data['title'],
                'description'   => $data['description'] ?? null,
                'price'         => $data['price'],
                'quantity_type' => $data['quantity_type'],
                'sort_order'    => $nextSort,
            ]);

            // Create menu images from newline-separated URLs
            $urls = preg_split('/\r\n|\r|\n/', $data['image_urls'] ?? '');
            $urls = array_values(array_filter(array_map('trim', $urls)));

            foreach ($urls as $url) {
                $menu->images()->create([
                    'image_url' => $url,
                ]);
            }
        });
    } catch (\Throwable $e) {
        return back()
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }

    return redirect()->route('menu.index')->with('success', 'Menu created successfully!');
}


    public function show(Menu $menu)
    {
        $menu->load(['images', 'variations', 'addOns']);
        return view('admin.pages.menu.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $menu->load(['images', 'variations', 'addOns']);
        return view('admin.pages.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity_type' => 'required|string',
            'image_urls' => 'nullable|string',
            'variations' => 'array',
            'add_ons' => 'array',
        ]);

        try {
            DB::transaction(function () use ($data, $request, $menu) {
                $menu->update($data);

                // Update images
                $menu->images()->delete();
                if (!empty($data['image_urls'])) {
                    $urls = array_filter(array_map('trim', explode("\n", $data['image_urls'])));
                    foreach ($urls as $url) {
                        $menu->images()->create(['image_url' => $url]);
                    }
                }

                // Update variations
                $menu->variations()->delete();
                if ($request->has('variations')) {
                    foreach ($request->input('variations') as $variation) {
                        if (!empty($variation['name'])) {
                            $menu->variations()->create([
                                'name' => $variation['name'],
                                'price' => $variation['price'] ?? 0,
                            ]);
                        }
                    }
                }

                // Update add-ons
                $menu->addOns()->delete();
                if ($request->has('add_ons')) {
                    foreach ($request->input('add_ons') as $addOn) {
                        if (!empty($addOn['name'])) {
                            $menu->addOns()->create([
                                'name' => $addOn['name'],
                                'price' => $addOn['price'] ?? 0,
                            ]);
                        }
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route('menu.index')->with('success', 'Menu updated successfully!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully!');
    }

    public function reorder(Request $request)
{
    $data = $request->validate([
        'ids' => ['required', 'array'],
        'ids.*' => ['integer', 'exists:menus,id'],
    ]);

    DB::transaction(function () use ($data) {
        foreach ($data['ids'] as $index => $id) {
            Menu::where('id', $id)->update([
                'sort_order' => $index + 1,
            ]);
        }
    });

    return response()->json(['ok' => true]);
}
}
