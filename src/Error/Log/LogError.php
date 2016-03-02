<?php

namespace Error\Log;

use Error\Log\LogErrorConfig;
use Error\FileSystem\Directory;
use Error\FileSystem\File;

class LogError extends LogErrorConfig
{
    const ERROR_REPORTIONG = 'E_ALL | E_STRICT | E_NOTICE | E_WARNING';

    function __construct()
    {
        set_error_handler(array($this, 'errorHandler'));

        error_reporting(self::ERROR_REPORTIONG ? self::ERROR_REPORTIONG : E_ALL);
    }

    public function errorHandler($errno, $str, $file, $line, $context = null)
    {
        $this->_exceptionHandler(new ErrorException($str, 0, $errno, $file, $line));
    }

    public function logError($title, $message, $details, $critical = false)
    {
        $this->_saveLog($title, $message, $details, ($critical ? 3: 2));
    }

    private function _exceptionHandler($e)
    {
        $error_title = 'Fatal error code';
        $error_message = $e->getMessage();
        $error_details = 
            'Type: '.get_class($e).
            ', File: '.$e->getFile().
            ', Line: '.$e->getLine();

        $this->logError($error_title, $error_message, $error_details, true);
    }

    private function _saveLog($title, $message, $details, $type = 0, $db = false, $mail = false)
    {
        $dir_log = $this->data_config['dir_log'];

        if ($dir_log)
        {
            try
            {
                // Verifica/cria diretório do log
                if (!is_dir($dir_log))
                {
                    $is_dir = Directory::createDir($dir_log);
                }
                else $is_dir = true;

                if ($is_dir)
                {
                    // Cria arquivo de log
                    $path_log = $dir_log.'/'.$this->data_config['file_log'].date('Y-m-d').'.log';
                    $text = date('Y-m-d H:i:s').': '.$title.' *** '.$message.'::'.$details;
                    File::createLog($path_log, $text);
                }
            }
            catch(Exception $e)
            {
                throw new Exception();
            }
        }
    }
}
