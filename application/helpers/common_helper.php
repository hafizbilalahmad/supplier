<?php

function show($data,$title='',$stop=1){
  if($title!=''){
    echo "<pre><h2> $title </h2></pre>";
  }
  echo "<pre style='font-weight:bold'>";
  print_r($data);
  echo "</pre>";
  if($stop){
    die();
  }
}

function set_subarrays_index_by_column_value($data,$column){
    $result = [];
    foreach ($data as $key => $value) {
        $result[$value[$column]] = $value;
    }
    return $result;
}
function set_subarray_multiple_index_by_coulnm_value($mainarray,$index){
    $temp = $mainarray[0][$index];
    $i = -1;
    $result = [];
    foreach ($mainarray as $key => $value) {
        if($temp == $value[$index]){
            $i++;
        }else {
            $i = 0;
            $temp = $value[$index];
        }
        $result[$value[$index]][$i] = $value;
    }
    return $result;
}
