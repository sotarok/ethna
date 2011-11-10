<?php
/**
 *
 *  ClassLoader for Application
 *
 *  Note:
 *  Appid_Action
 *  Appid_View
 *  Appid_*
 */

class Ethna_ClassLoader_App
    extends Ethna_ClassLoader_Base
    implements Ethna_ClassLoader_ClassLoaderInterafce
{

    protected $ctl;
    protected $controller;

    protected $appid;
    protected $basedir;

    public function __construct($basedir, $controller)
    {
        $this->basedir = $basedir;
        $this->controller = $this->ctl = $controller;
    }

    public function getFileName($class_name)
    {
        // TODO :
        $action_class_prefix = $this->appid . '_Action_';
        if (0 === strpos($class_name, $action_class_prefix)) {
            $action_basedir = $this->action_dir
                . DIRECTORY_SEPARATOR;
            $file_name = str_replace($action_class_prefix, '', $class_name);
            $file_name = $action_basedir . preg_replace('/([a-z])([A-Z])/e', '\$1.ucfirst(\'\$2\')', $file_name) . '.php';
            var_dump("action: $file_name");
            return $file_name;
        }

        $view_class_prefix = $this->appid . '_View_';
        if (0 === strpos($class_name, $view_class_prefix)) {
            $view_basedir = $this->ctl->getDirectory('view')
                . DIRECTORY_SEPARATOR;
            $file_name = str_replace($view_class_prefix, '', $class_name);
            $file_name = $view_basedir . preg_replace('/([a-z])([A-Z])/e', '\$1.ucfirst(\'\$2\')', $file_name) . '.php';
            var_dump("view: $file_name");
            return $file_name;
        }

        $file_name = $this->app_dir
            . DIRECTORY_SEPARATOR . $class_name . '.php';
        var_dump("app: $file_name");
        return $file_name;
    }
}
