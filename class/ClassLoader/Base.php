<?php
/**
 *
 *  Base.php
 *
 *  @package    Ethna
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 */

/**
 *  Ethna_ClassLoader_Base
 *
 *  @package    Ethna
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 */
class Ethna_ClassLoader_Base
{
    public function loadClass($class_name)
    {
        $file_name = $this->getFileName($class_name);
        //var_dump($file_name);
        if ($this->isReadable($file_name)) {
            require $file_name;
            return true;
        }
    }

    public function isReadable($file_name)
    {
        if (is_file($file_name) && is_readable($file_name)) {
            return true;
        }
        return false;
    }
}
