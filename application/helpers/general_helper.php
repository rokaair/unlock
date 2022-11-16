<?php defined('BASEPATH') OR exit('No direct script access allowed');
function increment_date($date, $increment)
{
    $new_date = new DateTime($date);
    $new_date->add(new DateInterval('P' . $increment));
    return $new_date->format('Y-m-d');
}

if(!function_exists('getWarrantyStatus')) {
  function getWarrantyStatus($date_closing, $warranty, $fontsize = NULL) {

    if ($warranty !== '' && $warranty !== '0' && $warranty !== 'warranty') {

      if (!$date_closing) {
        return '<span class="label" style="display:block !important;white-space: inherit;background-color: #ccc;">Warranty not started</span>';
      }
      $new_date = increment_date(date("Y-m-d", strtotime($date_closing)), $warranty);
      $datetime1 = new DateTime();
      $datetime2 = new DateTime($new_date);
      $interval = $datetime1->diff($datetime2);

      $diff = (int)$interval->format("%r%a");
      if ($diff < 0) {
        return '<span class="label"  style="background-color: #ccc;width: 100%;line-height: 1.5;background-color: #ccc;'.($fontsize ? 'font-size:'.$fontsize : '').'">Warranty ended on '.date('d-m-Y', strtotime($new_date)).'</span>';
      }else{
        $elapsed = $interval->format('%m months %a days %h hours');
        return '<span style="font-size: 26px;display:block !important;white-space: inherit;'.($fontsize ? 'font-size:'.$fontsize : '').'" class="label label-success">Warranty Start '.date('d-m-Y', strtotime($date_closing)).'<br> Warranty End: '.date('d-m-Y', strtotime($new_date)).'</span>';
      }
    }else{
      return '<span class="label" style="display:block !important;white-space: inherit;background-color: #ccc;">No Warranty</span>';
    }
  }
}

if(!function_exists('isInWarranty')) {
  function isInWarranty($date_closing, $warranty, $fontsize = NULL) {
    // $warranty = '1Y';
    if ($warranty !== '' && $warranty !== '0' && $warranty !== 'warranty') {
      if (!$date_closing) {
        return true;

      }
      $new_date = increment_date(date("Y-m-d", strtotime($date_closing)), $warranty);
      $datetime1 = new DateTime();
      $datetime2 = new DateTime($new_date);
      $interval = $datetime1->diff($datetime2);

      $diff = (int)$interval->format("%r%a");
      if ($diff < 0) {
        return false;
      }else{
        $elapsed = $interval->format('%m months %a days %h hours');
        return true;
      }
    }else{
      return false;
    }
  }
}