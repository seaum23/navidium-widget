<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use App\Models\Merchant;
use App\Models\Metafield;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;

class VariantController extends Controller
{
    use ApiResponse;

    /**
     * Store a newly created resource in storage.
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $shop_url = $params['shop_url'];
        $price = 0;
        if (isset($params['price'])) {
            $price = (float) $params['price'];
        }
        if (isset($params['currency'])) {
            include 'rate.php';
            if (isset($rate)) {
                $rate = (float) $rate;
                $raw_price = $rate * $price;
            } else {
                $raw_price = $price;
            }

            $raw_price = round($raw_price, 2);
        } else {
            $raw_price = $price;
        }

        $rounding_protection = 'rounding_down';

        $merchant = Merchant::where('shop_url', $shop_url)->firstOrFail();
        $rounding_protection = $merchant->rounding_protection;

        $nvd_protection_type = 1;
        $nvd_protection_percentage = 2;
        $result_meta = Metafield::where('shop_url', $shop_url)
            ->whereIn('meta_key', ['nvd_protection_type', 'nvd_protection_type_value'])
            ->get();

        foreach ($result_meta as $meta_row) {
            if ($meta_row->meta_key == 'nvd_protection_type') {
                $nvd_protection_type = $meta_row->meta_value;
            } elseif ($meta_row->meta_key == 'nvd_protection_type_value') {
                $nvd_protection_percentage = $meta_row->meta_value;
            }
        }

        $nvd_protection_percentage = (float) $nvd_protection_percentage;
        $divide_nvd_protection_percentage = $nvd_protection_percentage / 100;
        $final_price = $raw_price * $divide_nvd_protection_percentage;
        //$final_price = ($raw_price*($nvd_protection_percentage/100));
        $price = $final_price;

        $nvd_variants = [];
        $nvd_variants_x = [];

        //variants getter
        // $nvd_variants_sql = "SELECT `variant_id`,`range_from`,`range_to`,`price`,`active_status`,`skip_status` FROM `ecomnvd_navidium`.`nvd_variants` WHERE `shop_url` = '$shop_url' AND `deleted` = 0";
        // $nvd_variants_query = mysqli_query($conn,$nvd_variants_sql);
        $nvd_variants_query = Variant::where('shop_url', $shop_url)->get();

        foreach ($nvd_variants_query as $variant) {
            $variant_id = $variant->variant_id;
            $variant_price = $variant->price;
            $skip_status = $variant->skip_status;
            $active_status = $variant->active_status;

            if ($variant->active_status == 1) {
                $nvd_variants[] = $variant;
            }

            if ($skip_status == '0') {
                $nvd_variants_x[$variant_id] = $variant_price;
            }
        }
        // dd($nvd_variants);

        asort($nvd_variants_x);
        array_multisort(array_column($nvd_variants, 'range_from'), SORT_ASC, $nvd_variants);

        $min_variant_id = '';
        $min_variant_price_db = '';

        $first_key = array_key_first($nvd_variants_x);
        $min_variant_id = $first_key;
        $min_variant_price_db = round($nvd_variants_x[$first_key], 2);

        $max_variant_id = '';
        $max_variant_price_db = '';
        $last_key = array_key_last($nvd_variants_x);
        $max_variant_id = $last_key;
        $max_variant_price_db = round($nvd_variants_x[$last_key], 2);

        if (isset($nvd_protection_type) && $nvd_protection_type == true) {
            if ($price <= $min_variant_price_db) {
                $post_data = ['variant_id' => (int) $min_variant_id, 'price' => $min_variant_price_db];
            } elseif ($price >= $max_variant_price_db) {
                $post_data = ['variant_id' => (int) $max_variant_id, 'price' => $max_variant_price_db];
            } else {
                $calculated_protection_price = $this->findClosest(array_values($nvd_variants_x), $price, $rounding_protection);
                $expected_variant_id = array_search($calculated_protection_price, $nvd_variants_x);

                $post_data = ['variant_id' => $expected_variant_id, 'price' => $calculated_protection_price];
            }
        } else {
            $post_data = ['variant_id' => (int) $min_variant_id, 'price' => $min_variant_price_db];
            $i = 0;
            foreach ($nvd_variants as $variant) {

                $from = (float)$variant['range_from'];
                $to = (float)$variant['range_to'];

                if (isset($nvd_variants[$i + 1])) {
                    $next_from = (float)$nvd_variants[$i + 1]["range_from"];
                }

                $final_variant_id = (int)$nvd_variants[0]["variant_id"];
                $final_variant_price = $nvd_variants[0]["price"];

                if (isset($next_from) && $raw_price < $from && $raw_price < $next_from) {
                    $qa_one = true;
                    $final_variant_id = (int)$variant["variant_id"];
                    $final_variant_price = $variant["price"];
                } else if ($raw_price > $to && !isset($next_from)) {
                    $final_variant_id = (int)$variant["variant_id"];
                    $final_variant_price = $variant["price"];
                }

                if ($from <= $raw_price && $raw_price <= $to) {
                    $final_variant_id = (int)$variant["variant_id"];
                    $final_variant_price = $variant["price"];
                    break;
                }

                $i++;

                if (isset($next_from)) {
                    unset($next_from);
                }
            }
            $post_data = ['variant_id' => (int) $final_variant_id, 'price' => $final_variant_price];

        }

        return $this->successResponse($post_data);
    }

    public function findClosest($arr, $target, $adjustment = 'rounding_down')
    {
        if (!$arr || !count($arr)) {
            return null;
        }
        $toMatch = (float) $target;
        $finalOutput = 0.0;
        $n = count($arr);
        for ($i = 0; $i < $n; $i++) {
            $current = $arr[$i];
            $next = $arr[$i + 1];
            if ($toMatch >= $current && $toMatch <= $next) {
                if ($adjustment === 'rounding_down') {
                    $finalOutput = $current;
                }
                if ($adjustment === 'rounding_up') {
                    $finalOutput = $next;
                }
                break;
            } elseif ($toMatch <= $current) {
                $finalOutput = $current;
                break;
            }
        }
        return (float) $finalOutput;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
