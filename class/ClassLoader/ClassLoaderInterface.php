<?php
/**
 *
 */


interface Ethna_ClassLoader_ClassLoaderInterafce
{
    public function loadClass($class_name);
    public function getFileName($class_name);
}
