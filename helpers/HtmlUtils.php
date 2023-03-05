<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\helpers;

class HtmlUtils {

    public static function lineTextCenter($text) {
        return '<div style="width: 100%; height: 13px; border-bottom: 1px solid #e5e5e5; text-align: center; margin-bottom:25px;">
  <span style="font-size: 20px; background-color: #ffff; padding: 0 10px;">
    <b>' . $text . '</b> <!--Padding is optional-->
  </span>
</div>';
    }

}
