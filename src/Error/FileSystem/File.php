<?php

namespace Error\FileSystem;

class File
{
    public function createLog($path, $text)
    {
        @file_put_contents($path, $text);
    }
}
