<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.better_escape.php
 * Type:     modifier
 * Name:     better_escape
 * Purpose:  returns correct encoded string (not empty as htmlentities does)
 * -------------------------------------------------------------
 */
function smarty_modifier_better_escape($output) {
    return htmlentities(utf8_encode($output));
}
