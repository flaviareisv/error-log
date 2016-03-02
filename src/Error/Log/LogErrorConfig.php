<?php

namespace Error\Log;

class LogErrorConfig
{
    protected $data_config = 
        array(
            'admin_mail'=>'',
            'dir_log'=>'',
            'file_log'=>'error-log'
        );

    public function setConfigLog($config)
    {
        if (is_array($config)) {
            $this->data_config = array_replace($this->data_config, $config);
        }
    }

    public function getConfigLog()
    {
        return $this->data_config;
    }
}
