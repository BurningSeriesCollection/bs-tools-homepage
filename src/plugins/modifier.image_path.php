<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.image_path.php
 * Type:     modifier
 * Name:     image_path
 * Purpose:  return image path when valid, else default image
 * -------------------------------------------------------------
 */
function smarty_modifier_image_path($output) {
    if(!is_null($output) && !empty($output)) {
        return $output;
    } else {
        return '/img/no_image.png';
    }
}
