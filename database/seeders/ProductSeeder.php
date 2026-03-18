<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (!Category::query()->exists()) {
            return;
        }

        $categoryMap = Category::query()->pluck('id', 'name');
        $fallbackCategoryId = Category::query()->value('id');

        $products = [
            ['name' => 'iPhone 15 Pro Max', 'category' => 'Phones', 'price' => 69999, 'stock' => 12, 'image' => 'https://images.pexels.com/photos/1275229/pexels-photo-1275229.jpeg'],
            ['name' => 'Samsung Galaxy S24 Ultra', 'category' => 'Phones', 'price' => 58999, 'stock' => 10, 'image' => 'https://images.pexels.com/photos/1092644/pexels-photo-1092644.jpeg'],
            ['name' => 'Google Pixel 8 Pro', 'category' => 'Phones', 'price' => 45999, 'stock' => 8, 'image' => 'https://images.pexels.com/photos/404280/pexels-photo-404280.jpeg'],
            ['name' => 'Xiaomi 14 Pro', 'category' => 'Phones', 'price' => 39999, 'stock' => 9, 'image' => 'https://images.pexels.com/photos/699122/pexels-photo-699122.jpeg'],
            ['name' => 'OnePlus 12', 'category' => 'Phones', 'price' => 36999, 'stock' => 7, 'image' => 'https://images.pexels.com/photos/47261/pexels-photo-47261.jpeg'],

            ['name' => 'MacBook Pro 16 M3', 'category' => 'Laptops', 'price' => 119999, 'stock' => 5, 'image' => 'https://images.pexels.com/photos/18105/pexels-photo.jpg'],
            ['name' => 'Dell XPS 15', 'category' => 'Laptops', 'price' => 87999, 'stock' => 6, 'image' => 'https://images.pexels.com/photos/205421/pexels-photo-205421.jpeg'],
            ['name' => 'HP Spectre x360', 'category' => 'Laptops', 'price' => 74999, 'stock' => 6, 'image' => 'https://images.pexels.com/photos/7974/pexels-photo.jpg'],
            ['name' => 'Lenovo Legion 5', 'category' => 'Laptops', 'price' => 65999, 'stock' => 8, 'image' => 'https://images.pexels.com/photos/374074/pexels-photo-374074.jpeg'],
            ['name' => 'ASUS ROG Zephyrus G14', 'category' => 'Laptops', 'price' => 79999, 'stock' => 5, 'image' => 'https://images.pexels.com/photos/1229861/pexels-photo-1229861.jpeg'],

            ['name' => 'iPad Pro 12.9', 'category' => 'Tablets', 'price' => 52999, 'stock' => 9, 'image' => 'https://images.pexels.com/photos/1334597/pexels-photo-1334597.jpeg'],
            ['name' => 'Samsung Galaxy Tab S9', 'category' => 'Tablets', 'price' => 37999, 'stock' => 11, 'image' => 'https://images.pexels.com/photos/1591060/pexels-photo-1591060.jpeg'],
            ['name' => 'Xiaomi Pad 6', 'category' => 'Tablets', 'price' => 21999, 'stock' => 14, 'image' => 'https://images.pexels.com/photos/193004/pexels-photo-193004.jpeg'],
            ['name' => 'Lenovo Tab P12', 'category' => 'Tablets', 'price' => 19999, 'stock' => 12, 'image' => 'https://images.pexels.com/photos/5082566/pexels-photo-5082566.jpeg'],
            ['name' => 'Huawei MatePad 11', 'category' => 'Tablets', 'price' => 24999, 'stock' => 10, 'image' => 'https://images.pexels.com/photos/5082567/pexels-photo-5082567.jpeg'],

            ['name' => 'Sony WH-1000XM5', 'category' => 'Accessories', 'price' => 15999, 'stock' => 20, 'image' => 'https://images.pexels.com/photos/3394650/pexels-photo-3394650.jpeg'],
            ['name' => 'AirPods Pro 2', 'category' => 'Accessories', 'price' => 9999, 'stock' => 22, 'image' => 'https://images.pexels.com/photos/3780681/pexels-photo-3780681.jpeg'],
            ['name' => 'Anker 737 Power Bank', 'category' => 'Accessories', 'price' => 4999, 'stock' => 18, 'image' => 'https://images.pexels.com/photos/4526407/pexels-photo-4526407.jpeg'],
            ['name' => 'Logitech MX Master 3S', 'category' => 'Accessories', 'price' => 4299, 'stock' => 16, 'image' => 'https://images.pexels.com/photos/2115257/pexels-photo-2115257.jpeg'],
            ['name' => 'Apple Watch Series 9', 'category' => 'Accessories', 'price' => 18999, 'stock' => 12, 'image' => 'https://images.pexels.com/photos/437037/pexels-photo-437037.jpeg'],

            ['name' => 'PlayStation 5 Console', 'category' => 'Gaming', 'price' => 31999, 'stock' => 9, 'image' => 'https://images.pexels.com/photos/3945659/pexels-photo-3945659.jpeg'],
            ['name' => 'Xbox Series X', 'category' => 'Gaming', 'price' => 29999, 'stock' => 8, 'image' => 'https://images.pexels.com/photos/442576/pexels-photo-442576.jpeg'],
            ['name' => 'Nintendo Switch OLED', 'category' => 'Gaming', 'price' => 17999, 'stock' => 13, 'image' => 'https://images.pexels.com/photos/275033/pexels-photo-275033.jpeg'],
            ['name' => 'DualSense Wireless Controller', 'category' => 'Gaming', 'price' => 3499, 'stock' => 24, 'image' => 'https://images.pexels.com/photos/845255/pexels-photo-845255.jpeg'],
            ['name' => 'Razer BlackWidow V4', 'category' => 'Gaming', 'price' => 5999, 'stock' => 15, 'image' => 'https://images.pexels.com/photos/7915437/pexels-photo-7915437.jpeg'],

            ['name' => 'Canon EOS R10', 'category' => 'Cameras', 'price' => 48999, 'stock' => 7, 'image' => 'https://images.pexels.com/photos/51383/photo-camera-subject-photographer-51383.jpeg'],
            ['name' => 'Sony Alpha a7 IV', 'category' => 'Cameras', 'price' => 99999, 'stock' => 4, 'image' => 'https://images.pexels.com/photos/90946/pexels-photo-90946.jpeg'],
            ['name' => 'Nikon Z6 II', 'category' => 'Cameras', 'price' => 82999, 'stock' => 5, 'image' => 'https://images.pexels.com/photos/821652/pexels-photo-821652.jpeg'],
            ['name' => 'Fujifilm X-T5', 'category' => 'Cameras', 'price' => 76999, 'stock' => 4, 'image' => 'https://images.pexels.com/photos/51383/photo-camera-subject-photographer-51383.jpeg'],
            ['name' => 'GoPro HERO12 Black', 'category' => 'Cameras', 'price' => 23999, 'stock' => 11, 'image' => 'https://images.pexels.com/photos/163065/mobile-phone-android-apps-phone-163065.jpeg'],

            ['name' => 'Nike Air Max 270', 'category' => 'Clothes', 'price' => 4999, 'stock' => 30, 'image' => 'https://images.pexels.com/photos/2529148/pexels-photo-2529148.jpeg'],
            ['name' => 'Adidas Essentials Hoodie', 'category' => 'Clothes', 'price' => 1999, 'stock' => 26, 'image' => 'https://images.pexels.com/photos/6311392/pexels-photo-6311392.jpeg'],
            ['name' => 'Levi\'s 511 Jeans', 'category' => 'Clothes', 'price' => 2499, 'stock' => 22, 'image' => 'https://images.pexels.com/photos/1598507/pexels-photo-1598507.jpeg'],
            ['name' => 'Puma Sports T-Shirt', 'category' => 'Clothes', 'price' => 899, 'stock' => 40, 'image' => 'https://images.pexels.com/photos/6311605/pexels-photo-6311605.jpeg'],
            ['name' => 'Under Armour Training Shorts', 'category' => 'Clothes', 'price' => 1299, 'stock' => 28, 'image' => 'https://images.pexels.com/photos/1431282/pexels-photo-1431282.jpeg'],
        ];

        // Keep the data simple for internship demo: reset products and orders then seed curated list.
        Order::query()->delete();
        Product::query()->delete();

        foreach ($products as $item) {
            Product::query()->create([
                'name' => $item['name'],
                'price' => $item['price'],
                'stock' => $item['stock'] ?? 10,
                'category_id' => $categoryMap[$item['category']] ?? $fallbackCategoryId,
                'image' => $item['image'],
            ]);
        }
    }
}
