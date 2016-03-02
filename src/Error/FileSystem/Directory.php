<?php

namespace Error\FileSystem;

class Directory
{
    public function createDir($dir)
    {
        $create = mkdir($dir, 0777);

        return $create;
    }
}
