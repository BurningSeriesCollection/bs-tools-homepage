<?php

require_once('includes/Flucky.class.php');

abstract class BaseController extends Flucky {
    abstract public function process($args);
    abstract public function setCacheableVars();
    
    protected function showMessage($message, $status) {
        $this->assign('message', $message);
        $this->assign('status', $status);
        return 'info.tpl';
    }
}
