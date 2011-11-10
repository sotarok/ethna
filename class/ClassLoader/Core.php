<?php
/**
 *
 *  Base.php
 *
 *  @package    Ethna
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 */

/**
 *  Ethna_ClassLoader_Core
 *
 *  @package    Ethna
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 */
class Ethna_ClassLoader_Core
    extends Ethna_ClassLoader_Base
    implements Ethna_ClassLoader_ClassLoaderInterafce
{
    protected $basedir;

    public function __construct($basedir)
    {
        $this->basedir = $basedir;
    }

    public function getFileName($class_name)
    {
        $class_name = str_replace('Ethna_', '', $class_name);
        $file_name = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

        return $this->basedir . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $file_name;
    }
}
