<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('gallery_item_tag')->truncate();
        GalleryItem::truncate();
        Tag::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ── Tags ─────────────────────────────────────────────────────────
        $tagNames = [
            'dessert', 'cookies', 'cupcakes', 'muffins', 'brownies',
            'cheesecake', 'mochi', 'rice krispies',
            'pandan', 'ube', 'banana', 'blueberry', 'vanilla',
        ];

        $tags = [];
        foreach ($tagNames as $name) {
            $tag = Tag::create(['name' => $name, 'slug' => Str::slug($name)]);
            $tags[$name] = $tag->id;
        }

        // ── Gallery items ─────────────────────────────────────────────────
        $items = [
            [
                'title'     => 'Pandan Cupcakes',
                'caption'   => 'Light and fluffy pandan cupcakes with vanilla buttercream rose design ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360339/IMG_4837_jpg_uobogx.jpg',
                'tags'      => ['dessert', 'cupcakes', 'pandan'],
            ],
            [
                'title'     => 'Ube Cupcakes',
                'caption'   => 'Gorgeous ube cupcakes with vanilla buttercream in a rose design ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360336/IMG_2945_jpg_unrem2.jpg',
                'tags'      => ['dessert', 'cupcakes', 'ube'],
            ],
            [
                'title'     => 'Pandan Rice Krispies',
                'caption'   => 'Crispy, sticky, and gooey rice krispies flavored with pandan extract ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360336/IMG_6700_jpg_f5cwid.jpg',
                'tags'      => ['dessert', 'rice krispies', 'pandan'],
            ],
            [
                'title'     => 'Vanilla Cupcakes',
                'caption'   => 'Classic vanilla cupcakes with beautiful vanilla buttercream ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360334/IMG_0051_jpg_yyogax.jpg',
                'tags'      => ['dessert', 'cupcakes', 'vanilla'],
            ],
            [
                'title'     => 'Banana Cookies',
                'caption'   => 'Chewy banana cookies with white chocolate chips ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360332/IMG_7864_jpg_mmyvif.jpg',
                'tags'      => ['dessert', 'cookies', 'banana'],
            ],
            [
                'title'     => 'Ube Rice Krispies',
                'caption'   => 'Crispy, sticky, and gooey rice krispies flavored with ube extract ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360332/IMG_8226_jpg_ep1yhb.jpg',
                'tags'      => ['dessert', 'rice krispies', 'ube'],
            ],
            [
                'title'     => 'Pandan Mochi',
                'caption'   => 'Soft, chewy, slightly gooey mochi cake flavored with pandan extract ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_5383_jpg_awfugr.jpg',
                'tags'      => ['dessert', 'mochi', 'pandan'],
            ],
            [
                'title'     => 'Pandan Cookies',
                'caption'   => 'Chewy pandan cookies with white chocolate chips ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_5286_qmvnvr.jpg',
                'tags'      => ['dessert', 'cookies', 'pandan'],
            ],
            [
                'title'     => 'Ube Cookies',
                'caption'   => 'Chewy ube cookies with white chocolate chips ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_6056_u3bhr2.jpg',
                'tags'      => ['dessert', 'cookies', 'ube'],
            ],
            [
                'title'     => 'Ube Mochi',
                'caption'   => 'Soft, chewy, slightly gooey mochi cake flavored with ube extract ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360326/IMG_1141_jpg_fo4eqk.jpg',
                'tags'      => ['dessert', 'mochi', 'ube'],
            ],
            [
                'title'     => 'Oatmeal Cookies',
                'caption'   => 'Classic hearty oatmeal cookies with a chewy center and crispy edges ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360326/37A71E63-0C7B-498D-988D-D598EBD881DC_nr90cg.jpg',
                'tags'      => ['dessert', 'cookies'],
            ],
            [
                'title'     => 'White Chocolate Chip Brownies',
                'caption'   => 'Fudgy brownie squares with a soft center and crispy edges ♡',
                'image_url' => 'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360325/IMG_6017_jpg_edgyxj.jpg',
                'tags'      => ['dessert', 'brownies'],
            ],
        ];

        foreach ($items as $sort => $data) {
            $item = GalleryItem::create([
                'title'      => $data['title'],
                'caption'    => $data['caption'],
                'image_url'  => $data['image_url'],
                'is_active'  => true,
                'sort_order' => $sort + 1,
            ]);

            $tagIds = array_map(fn($name) => $tags[$name], $data['tags']);
            $item->tags()->sync($tagIds);
        }
    }
}
