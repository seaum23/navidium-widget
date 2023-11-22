<?php

namespace App\Models\Bumps;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ShopifyController;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Services\Shopify\GetProductWithVariantService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory;
    
    protected $connection = 'bumps';
    protected $table = 'nvd_bumps_product_feeds';
    protected $guarded = [];

    /**
     * Interact with the user's first name.
     */
    protected function productHandles(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value),
        );
    }

    public static function getProductsFromShopify($feeds, $merchant){
        $shopify_controller = new ShopifyController;
        $product_ids = "";
        $varient_ids = "";
        $total_count = 0;

        foreach($feeds as $feed){
            $products = explode(',',$feed->product_ids);
            // var_dump($products);exit;
            if($products === null){
                continue;
            };
            $total_count += count($products);

            foreach($products as $product){
                $product_ids .= 'id:' . $product . " OR ";
            }
        }
        
        $product_ids = rtrim($product_ids, ' OR ');
        $shopify_response = GetProductWithVariantService::getProductWithVariant($product_ids, $total_count, $merchant);

        foreach($feeds as $feed){
            $products = explode(',',$feed->product_ids);
            if($products === null){
                continue;
            };
            $modified_product = NULL;
            $modified_products_arr = [];
            $skip = false;
            foreach($products as $product){
                $product_from_shopify = array_search("gid://shopify/Product/$product", array_column(array_column($shopify_response['products']['edges'], 'node'), 'id'));

                if($product_from_shopify !== false){
                    $modified_product = $shopify_response['products']['edges'][$product_from_shopify];
                    $modified_products_arr[] = $modified_product;
                }
            }
            if(!empty($modified_products_arr)){
                $feed->product_ids = json_encode(array_values($modified_products_arr), JSON_UNESCAPED_SLASHES);
            }
        }
    }
}
