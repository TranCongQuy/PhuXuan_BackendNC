<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Danh sách sản phẩm
     */
    public function products(Request $request)
    {
        // Dữ liệu sản phẩm mẫu
        $products = [
            ['id' => 1, 'name' => 'Sản phẩm A', 'description' => 'Mô tả sản phẩm A.', 'price' => '100.000₫', 'category' => 'Điện tử', 'image' => 'https://picsum.photos/300/200?random=1'],
            ['id' => 2, 'name' => 'Sản phẩm B', 'description' => 'Mô tả sản phẩm B.', 'price' => '200.000₫', 'category' => 'Thời trang', 'image' => 'https://picsum.photos/300/200?random=2'],
            ['id' => 3, 'name' => 'Sản phẩm C', 'description' => 'Mô tả sản phẩm C.', 'price' => '300.000₫', 'category' => 'Gia dụng', 'image' => 'https://picsum.photos/300/200?random=3'],
            ['id' => 4, 'name' => 'Sản phẩm D', 'description' => 'Mô tả sản phẩm D.', 'price' => '400.000₫', 'category' => 'Điện tử', 'image' => 'https://picsum.photos/300/200?random=4'],
            ['id' => 5, 'name' => 'Sản phẩm E', 'description' => 'Mô tả sản phẩm E.', 'price' => '500.000₫', 'category' => 'Thời trang', 'image' => 'https://picsum.photos/300/200?random=5'],
            ['id' => 6, 'name' => 'Sản phẩm F', 'description' => 'Mô tả sản phẩm F.', 'price' => '600.000₫', 'category' => 'Gia dụng', 'image' => 'https://picsum.photos/300/200?random=6'],
        ];

        // Lọc theo category (query string)
        $category = $request->query('category');
        if ($category) {
            $products = array_filter($products, function ($item) use ($category) {
                return $item['category'] === $category;
            });
            // Reset keys
            $products = array_values($products);
        }

        $categories = ['Điện tử', 'Thời trang', 'Gia dụng'];

        return view('shop.products', compact('products', 'categories', 'category'));
    }

    /**
     * Giỏ hàng
     */
    public function cart()
    {
        return view('shop.cart');
    }
}