<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ShopifyController;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Exceptions\ShopifyCallFailedException;
use App\Services\Shopify\GetProductWithVariantService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'nvd_upsell_feeds';
    protected $guarded = [];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getProductsFromShopify($feeds, $merchant){
        $shopify_controller = new ShopifyController;
        $product_ids = "";
        $varient_ids = "";
        $total_count = 0;

        foreach($feeds as $feed){
            $products = json_decode($feed->products, true);
            if($products === null){
                continue;
            };
            $total_count += count($products);

            foreach($products as $product){
                // legacy support
                if(!isset($product['product-id']) or !isset($product['variant-id'])){
                    continue;
                }
                $product_ids .= 'id:' . gidCleaner($product['product-id']) . " OR ";
                $varient_ids .= 'id:' . gidCleaner($product['variant-id']) . " OR ";
            }
        }
        
        $product_ids = rtrim($product_ids, ' OR ');
        $varient_ids = rtrim($varient_ids, ' OR ');
        $shopify_response = GetProductWithVariantService::getProductVariant($product_ids, $total_count, $varient_ids, $merchant);

        foreach($feeds as $feed){
            $products = json_decode($feed->products, true);
            if($products === null){
                continue;
            };
            $modified_product = NULL;
            $modified_products_arr = [];
            $skip = false;
            foreach($products as $product){
                // legacy support
                if(!isset($product['product-id'])){
                    $skip = true;
                    continue;
                }

                $already_inserted_product = isset($modified_products_arr['products']) ? array_search($product['product-id'], array_column(array_column($modified_products_arr['products']['edges'], 'node'), 'id')) : false;

                $product_from_shopify = array_search(isset($product['product-id']) ? $product['product-id'] : [], array_column(array_column($shopify_response['products']['edges'], 'node'), 'id'));
                $variant_from_shopify = array_search(isset($product['variant-id']) ? $product['variant-id'] : [], array_column($shopify_response['productVariants']['nodes'], 'id'));

                if($already_inserted_product !== false){
                    if($variant_from_shopify !== false){
                        $modified_products_arr[$already_inserted_product]['node']['variants']['nodes'][] = $shopify_response['productVariants']['nodes'][$variant_from_shopify];
                    }
                }else{
                    if($product_from_shopify !== false){
                        $modified_product = $shopify_response['products']['edges'][$product_from_shopify];
                    }
                    if($variant_from_shopify !== false){
                        $modified_product['node']['variants']['nodes'][0] = $shopify_response['productVariants']['nodes'][$variant_from_shopify];
                    }
                    $modified_products_arr[] = $modified_product;
                }
            }
            if(!$skip){
                $feed->products = json_encode(array_values($modified_products_arr), JSON_UNESCAPED_SLASHES);
            }
        }
    }
}
