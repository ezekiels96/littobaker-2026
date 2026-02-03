<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuPageController extends Controller
{
    public function index()
    {
        $menus = Menu::with('images')
            ->orderBy('sort_order')
            ->get();
        return view('pages.menu', compact('menus'));
    }
}
