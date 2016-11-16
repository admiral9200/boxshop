<?php

namespace app\Helpers;

use App\Category;
use App\Helpers\categoriesHelper;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;

class productsHelper
{
    public function getFieldToSuggestions($key)
    {
        switch ($key) {
            case 'product_purchased':
                return 'sale_counts';
            break;

            default:
                return 'view_counts';
            break;
        }
    }

    public function setToHaystack($products, $field = 'id')
    {
        if (empty(Session::get('suggest-listed'))) {
            Session::put('suggest-listed', []);
        }

        if (count($products) > 0) {
            foreach ($products as $value) {
                if (!in_array($value[$field], Session::get('suggest-listed'))) {
                    Session::push('suggest-listed', $value[$field]);
                }
            }
        }

        Session::save();
    }

    public function resetHaystack()
    {
        Session::forget('suggest-listed');
        Session::save();
    }

    public static function suggest($type, $limit = 4)
    {
        $data = [];
        switch ($type) {
            case 'purchased':
                $data['preferences_key'] = 'product_purchased';
                $data['limit'] = $limit;
            break;

            case 'categories':
                $data['preferences_key'] = 'product_categories';
                $data['limit'] = $limit;
                $usr_prefe = UserController::getPreferences('', $data['preferences_key']); //look up for user preferences
                if (count($usr_prefe['tags']) == 0) {
                    $data['category'] = ProductsController::getRandCategoryId(); //if there is not info, we get a rand category id
                } else {
                    $data['category'] = $usr_prefe['tags'][mt_rand(0, count($usr_prefe['tags']) - 1)]; //if so, we get a rand user preferences category
                }
            break;

            case 'viewed':
                $data['preferences_key'] = 'product_viewed';
                $data['limit'] = $limit;
            break;

            case 'carousel':
                return ProductsController::getTopRated(0, $limit, false);
            break;

            default:
                $data['limit'] = $limit;
                $data['preferences_key'] = '';
            break;
        }

        $suggest = ProductsController::getSuggestions($data); //suggestion array
        return $suggest;
    }

    public static function countingProductsByCategory($all_products, $categories)
    {
        $filters = ['category' => []];
        foreach ($categories as $value) {
            $category_id = $value['id'];
            $childs = \Cache::remember('progeny_of_'.$category_id, 15, function () use ($category_id) {
                Category::progeny($category_id, $childs, ['id']);

                return $childs;
            });

            $all = $childs;
            $childs = [];
            foreach ((array) $all as $val) {
                $childs[] = $val['id'];
            }

            $qty = 0;
            if ($all_products) {
                $qty = $all_products->where('category_id', $category_id)->count();
                $qty += $all_products->filter(function ($item) use ($childs) {
                    return in_array($item->category_id, $childs);
                }
                )->count();
            }
            if ($qty) {
                $filters['category'][$category_id]['id'] = $category_id;
                $filters['category'][$category_id]['name'] = $value['name'];
                $filters['category'][$category_id]['qty'] = $qty;
            }
        }

        if (isset($filters['category'])) {
            $filters['category'] = collect($filters['category'])->sortByDesc('qty');
        }

        return $filters;
    }

    public static function categoriesDropDownFormat($array, &$outPut)
    {
        foreach ($array as $row) {

            $level = categoriesHelper::level($array, $row['category_id']);

            $s = '';
            for ($i = 0; $i < $level; $i++) {
                $s .= '&nbsp;&nbsp;&nbsp;';
            }

            $icon = 2;
            if ($level % 3 == 0) {
                $icon = 0;
            } elseif ($level % 2 == 0) {
                $icon = 1;
            }

            $indentation = ['&#9679;', '&#8226;', '&ordm;'][$icon];
            $outPut[$row['id']] = $s.$indentation.'&nbsp;'.$row['name'];
        }
    }
}
