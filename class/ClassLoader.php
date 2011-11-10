<?php
/**
 * Ethna_ClassLoader
 *
 * This is a class loader factory of some styles of the class naming.
 * Register namespace-classloader mapping to this factory and then
 * register to autoload stack via spl_autoload_register().
 *
 * Ethna has three autoload classes:
 *
 * - Ethna_ClassLoader_Generic
 *
 *   - Like SplClassLoader to the technical interoperability standards for PHP 5.3 namespaces and
 *    class names (http://groups.google.com/group/php-standards/web/psr-0-final-proposal);
 *
 *     - A fully-qualified namespace and class must have the following structure <Vendor Name>()*
 *     - Each namespace must have a top-level namespace ("Vendor Name").
 *     - Each namespace can have as many sub-namespaces as it wishes.
 *     - Each namespace separator is converted to a DIRECTORY_SEPARATOR when loading from the file system.
 *     - Each "_" character in the CLASS NAME is converted to a DIRECTORYSEPARATOR. The "" character has no special meaning in the namespace.
 *     - The fully-qualified namespace and class is suffixed with ".php" when loading from the file system.
 *     - Alphabetic characters in vendor names, namespaces, and class names may be of any combination of lower case and upper case.
 *
 * - Ethna_ClassLoader_Core
 *
 *   - Class loader for the core classes of Ethna. This class loads Ethna classes based on ETHNA_BASE.
 *   - This loader doesn't have the compatibiliy with PSR-0 because of the backward compatibiliy of Ethna.
 *
 * - Ethna_ClassLoader_App
 *
 *   - Application class loader
 *   - This loader doesn't have the compatibiliy with PSR-0 because of the backward compatibiliy of
 *    the directory structure of the Ethna application.
 *
 */

class Ethna_ClassLoader
{
    private $_ns_map = array();

    /**
     * Creates a new <tt>SplClassLoader</tt> that loads classes of the
     * specified namespace.
     *
     * @param string $ns The namespace to use.
     */
    public function __construct(array $ns_map = array())
    {
        $this->_ns_map = $ns_map;
    }

    /**
     * Installs this class loader on the SPL autoload stack.
     */
    public function register($prepend = false)
    {
        return spl_autoload_register(array($this, 'loadClass'), false, $prepend);
    }

    /**
     * Uninstalls this class loader from the SPL autoloader stack.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     *
     */
    public function registerNamespace($ns, Ethna_ClassLoader_ClassLoaderInterafce $cl)
    {
        $this->_ns_map[$ns] = $cl;
    }

    /**
     *
     */
    public function unregisterNamespace($ns)
    {
        if (isset($this->_ns_map[$ns])) {
            unset($this->_ns_map[$ns]);
        }
        return $this;
    }

    /**
     */
    public function registerNamespaces(array $ns_map)
    {
        $this->_ns_map = array_merge(
            $this->_ns_map,
            $ns_map
        );
    }

    /**
     */
    public function getRegisteredNamespaces()
    {
        return $this->_ns_map;
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $class_name The name of the class to load.
     * @return void
     */
    public function loadClass($class_name)
    {
        foreach ($this->_ns_map as $ns => $cl) {
            $class_ns_prefix = substr($class_name, 0, strlen($ns . '\\'));
            $class_name_prefix = substr($class_name, 0, strlen($ns . '_'));
            if (($ns . '\\' === $class_ns_prefix)
                || ($ns . '_' === $class_name_prefix)
            ) {
                if ($cl->loadClass($class_name)) {
                    break;
                }
            }
        }
    }
}
