<?php

require_once('includes/BaseController.class.php');

class HomeController extends BaseController {
    public function process($args) {
        $this->assign('not_cached_var', date("D M d, Y G:i"));

        return 'home.tpl';
    }

    public function setCacheableVars() {
        $this->assign('cached_var', date("D M d, Y G:i"));
    }
}
