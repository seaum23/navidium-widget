<?php
$starttime = microtime(true);
$base = '/var/www/app.navidiumapp.com';
include $base.'/secured/cors-header.php';
include $base.'/secured/config.php';
include $base.'/secured/sanitize.php';

function findClosest($arr, $target, $adjustment = 'rounding_down') {
  if (!$arr || !count($arr)) return null;
  $toMatch = (float)$target;
  $finalOutput = 0.00;
  $n = count($arr);
  for ($i = 0; $i < $n; $i++) {
    $current = $arr[$i];
    $next = $arr[$i + 1];
    if ($toMatch >= $current && $toMatch <= $next) {
      if ($adjustment === 'rounding_down') $finalOutput = $current;
      if ($adjustment === 'rounding_up') $finalOutput = $next;
      break;
    } else if ($toMatch <= $current) {
      $finalOutput = $current;
      break;
    }
  }
  return (float)$finalOutput;
}

//get shop url when installing the script
$params = sanitizer($_GET);
if(isset($params['shop_url'])){
    $shop_url  = $params['shop_url'];
    $price = 0;
    if(isset($params['price'])){
        $price  = (float)$params['price'];
    }
    if(isset($params['currency'])){
        include 'rate.php';
        if(isset($rate)){
            $rate = (float)$rate;
            $raw_price = $rate*$price;
        }else{
            $raw_price = $price;
        }
        
        $raw_price = round($raw_price,2);
    }else{
        $raw_price = $price;
    }

    $rounding_protection = 'rounding_down';
    $sql_valid_merchant = "SELECT `rounding_protection` FROM `ecomnvd_navidium`.`nvd_merchants` WHERE `shop_url` = '$shop_url' AND `deleted` = 0 LIMIT 1";
    $result_valid_merchant = mysqli_query($conn,$sql_valid_merchant);
    
    if($result_valid_merchant!=null && mysqli_num_rows($result_valid_merchant)>0){
        $row_widget_settings = mysqli_fetch_assoc($result_valid_merchant);
        
        $rounding_protection = $row_widget_settings["rounding_protection"];
    }else{    
        $post_data['error'] = 'app uninstalled by shop';
        header('Content-Type: application/json');
        $return_json = json_encode($post_data);

        echo $return_json;
        die;
        exit;
    }
    

    $nvd_protection_type = 1;
    $nvd_protection_percentage = 2;
    $sql_meta = "SELECT `meta_value`,`meta_key` FROM `ecomnvd_navidium`.`nvd_meta` WHERE `shop_url` = '$shop_url' AND `meta_key` IN ('nvd_protection_type','nvd_protection_type_value') LIMIT 2";
    $result_meta = mysqli_query($conn,$sql_meta);

    foreach($result_meta as $meta_row){
        if($meta_row['meta_key']=='nvd_protection_type'){
            $nvd_protection_type = $meta_row["meta_value"];
        }else if($meta_row['meta_key']=='nvd_protection_type_value'){
            $nvd_protection_percentage = $meta_row["meta_value"];
        }
    }
    
    
    $nvd_protection_percentage = (float) $nvd_protection_percentage;
    $divide_nvd_protection_percentage = $nvd_protection_percentage/100;
    $final_price = $raw_price*$divide_nvd_protection_percentage; 
    //$final_price = ($raw_price*($nvd_protection_percentage/100)); 
    $price = $final_price;



    $nvd_variants = array();
    $nvd_variants_x = array();
    
    //variants getter
    $nvd_variants_sql = "SELECT `variant_id`,`range_from`,`range_to`,`price`,`active_status`,`skip_status` FROM `ecomnvd_navidium`.`nvd_variants` WHERE `shop_url` = '$shop_url' AND `deleted` = 0";
    $nvd_variants_query = mysqli_query($conn,$nvd_variants_sql);
    
    if($nvd_variants_query!=null && mysqli_num_rows($nvd_variants_query)>0){
        
        foreach($nvd_variants_query as $variant){
            $variant_id = $variant["variant_id"];
            $variant_price = $variant['price'];
            $skip_status = $variant['skip_status'];
            $active_status = $variant['active_status'];

            if($variant['active_status']==1){
                $nvd_variants[] = $variant; 
            }
            
            if($skip_status=='0'){
                $nvd_variants_x[$variant_id] = $variant_price;  
            }

        }
        
        asort($nvd_variants_x);
        array_multisort(array_column($nvd_variants, 'range_from'), SORT_ASC, $nvd_variants);
    }
    
    
    $min_variant_id = '';
    $min_variant_price_db = ''; 
    
    $first_key = array_key_first($nvd_variants_x);
    $min_variant_id = $first_key;
    $min_variant_price_db = round($nvd_variants_x[$first_key],2);
    
    $max_variant_id = '';
    $max_variant_price_db = '';
    $last_key = array_key_last($nvd_variants_x);
    $max_variant_id = $last_key;
    $max_variant_price_db = round($nvd_variants_x[$last_key],2);
    
    if(isset($nvd_protection_type) && $nvd_protection_type == true){

        if($price<=$min_variant_price_db){
            
            $post_data = array('variant_id'=>(int)$min_variant_id,'price'=>$min_variant_price_db);
            
        }else if($price>=$max_variant_price_db){

            $post_data = array('variant_id'=>(int)$max_variant_id,'price'=>$max_variant_price_db);
 
        }else{
            $calculated_protection_price = findClosest(array_values($nvd_variants_x), $price,$rounding_protection);
            $expected_variant_id = array_search((string)$calculated_protection_price,$nvd_variants_x,true);

            $post_data = array('variant_id'=>$expected_variant_id,'price'=>$calculated_protection_price);
        }
        
    }else{
        
        $post_data = array('variant_id'=>(int)$min_variant_id,'price'=>$min_variant_price_db);
        $i=0;
        foreach($nvd_variants as $variant){
            if($raw_price > (float)$variant["range_from"] && $raw_price < $nvd_variants[$i+1]["range_from"]){
               $post_data = array('variant_id'=>(int)$variant["variant_id"],'price'=>$variant["price"]);
            }else if($raw_price > (float)$variant["range_to"] && !isset($nvd_variants[$i+1])){
               $post_data = array('variant_id'=>(int)$variant["variant_id"],'price'=>$variant["price"]);
            }
            
            if((float)$variant["range_from"] <= $raw_price && $raw_price <= (float)$variant["range_to"]){
              $post_data = array('variant_id'=>(int)$variant["variant_id"],'price'=>$variant["price"]);
              break;
            }
            $i++;
        }

    }

}else{

    $post_data['error'] = 'invalid shop';
    
}

$endtime = microtime(true);
$post_data['execution_time'] = "Page loaded in ". round(($endtime - $starttime),2)." seconds";

header('Content-Type: application/json');
$return_json = json_encode($post_data,JSON_UNESCAPED_SLASHES);

echo $return_json;
mysqli_close($conn);
die;
exit;