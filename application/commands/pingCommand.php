<?php

class pingCommand extends \Easysite\Library\Command
{
    public function testAction()
    {
        $this->output('pong');
        if (!empty($this->_params)) {
            $this->output('params: ' . json_encode($this->_params));
        }
    }
}
