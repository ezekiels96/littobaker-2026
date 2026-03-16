<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        MenuImage::truncate();
        Menu::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $items = [
            [
                'title'         => 'Pandan Cookies',
                'description'   => 'Chewy soft cookies infused with pandan extract mixed with white chocolate chips',
                'price'         => 20.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_5286_qmvnvr.jpg',
                ],
            ],
            [
                'title'         => 'Ube Cookies',
                'description'   => 'Chewy soft cookies infused with ube extract mixed with white chocolate chips',
                'price'         => 20.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_6056_u3bhr2.jpg',
                ],
            ],
            [
                'title'         => 'Banana Cookies',
                'description'   => 'Chewy soft cookies made with ripe bananas mixed with white chocolate chips',
                'price'         => 20.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360332/IMG_7864_jpg_mmyvif.jpg',
                ],
            ],
            [
                'title'         => 'Cookies & Cream Cookies',
                'description'   => 'Chewy soft cookies loaded with crushed Oreo pieces and white chocolate chips',
                'price'         => 20.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_5286_qmvnvr.jpg',
                ],
            ],
            [
                'title'         => 'Oatmeal Cookies',
                'description'   => 'Classic hearty oatmeal cookies with a chewy center and crispy edges',
                'price'         => 20.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360326/37A71E63-0C7B-498D-988D-D598EBD881DC_nr90cg.jpg',
                ],
            ],
            [
                'title'         => 'Pandan Cupcakes',
                'description'   => 'A light moist fluffy pandan infused cake beautifully decorated with vanilla buttercream in a rose design',
                'price'         => 35.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360339/IMG_4837_jpg_uobogx.jpg',
                ],
            ],
            [
                'title'         => 'Ube Cupcakes',
                'description'   => 'A light moist fluffy ube infused cake beautifully decorated with vanilla buttercream in a rose design',
                'price'         => 35.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360336/IMG_2945_jpg_unrem2.jpg',
                ],
            ],
            [
                'title'         => 'Vanilla Cupcakes',
                'description'   => 'A light moist fluffy classic vanilla yellow cake beautifully decorated with vanilla buttercream in a rose design',
                'price'         => 35.00,
                'quantity_type' => 'dozen',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360334/IMG_0051_jpg_yyogax.jpg',
                ],
            ],
            [
                'title'         => 'Banana Muffins',
                'description'   => 'Classic moist and fluffy muffin made with ripe bananas topped with a crumbly buttery brown sugar streusel',
                'price'         => 25.00,
                'quantity_type' => 'dozen',
                'images'        => [],
            ],
            [
                'title'         => 'Blueberry Muffins',
                'description'   => 'Classic moist and fluffy muffin mixed with blueberries topped with a crumbly buttery brown sugar streusel',
                'price'         => 25.00,
                'quantity_type' => 'dozen',
                'images'        => [],
            ],
            [
                'title'         => 'Fudge White Chocolate Chip Brownies',
                'description'   => 'Rich moist fudgy decadent brownie squares with a soft center and crispy edges mixed with white chocolate chips',
                'price'         => 15.00,
                'quantity_type' => 'order',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360325/IMG_6017_jpg_edgyxj.jpg',
                ],
            ],
            [
                'title'         => 'Blueberry Cheesecake Bites',
                'description'   => 'Creamy, smooth classic cheesecakes with a crunchy graham cracker crust — perfectly portioned in convenient cupcake sized bites!',
                'price'         => 30.00,
                'quantity_type' => 'dozen',
                'images'        => [],
            ],
            [
                'title'         => 'Pandan Mochi',
                'description'   => 'A soft, chewy, slightly gooey mochi cake flavored with pandan extract',
                'price'         => 25.00,
                'quantity_type' => 'order',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360328/IMG_5383_jpg_awfugr.jpg',
                ],
            ],
            [
                'title'         => 'Ube Mochi',
                'description'   => 'A soft, chewy, slightly gooey mochi cake flavored with ube extract',
                'price'         => 25.00,
                'quantity_type' => 'order',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360326/IMG_1141_jpg_fo4eqk.jpg',
                ],
            ],
            [
                'title'         => 'Pandan Rice Krispies',
                'description'   => 'Classic crispy, sticky, and gooey rice krispies flavored with pandan extract',
                'price'         => 20.00,
                'quantity_type' => 'order',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360336/IMG_6700_jpg_f5cwid.jpg',
                ],
            ],
            [
                'title'         => 'Ube Rice Krispies',
                'description'   => 'Classic crispy, sticky, and gooey rice krispies flavored with ube extract',
                'price'         => 20.00,
                'quantity_type' => 'order',
                'images'        => [
                    'https://res.cloudinary.com/dtbjsvd1l/image/upload/v1770360332/IMG_8226_jpg_ep1yhb.jpg',
                ],
            ],
        ];

        foreach ($items as $sort => $data) {
            $menu = Menu::create([
                'name'          => $data['title'],
                'title'         => $data['title'],
                'description'   => $data['description'],
                'price'         => $data['price'],
                'quantity_type' => $data['quantity_type'],
                'sort_order'    => $sort + 1,
            ]);

            foreach ($data['images'] as $url) {
                MenuImage::create([
                    'menu_id'   => $menu->id,
                    'image_url' => $url,
                ]);
            }
        }
    }
}
