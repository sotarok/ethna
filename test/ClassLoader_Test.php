<?php
/**
 *  ClassLoader_Test.php
 *
 *  @author     Sotaro KARASAWA <sotaro.k@gmail.com>
 */

//{{{    Ethna_ClassLoader_Test
/**
 *  Test Case For Ethna_ClassLoader_Test
 *
 *  @access public
 */
class Ethna_ClassLoader_Test extends Ethna_UnitTestBase
{
    public function test_getFileName()
    {
        $cl = new Ethna_ClassLoader();
        //$cl->registerClassLoader(array(
        //    'Ethna' => new Ethna_ClassLoader_CoreClassLoader(),
        //    'App' => new Ethna_ClassLoader_AppClassLoader(),
        //));

        //$this->assertEqual('/path/to/Ethna/Hoge.php', $cl->getFileName('Ethna_Hoge', '/path/to', '_'));
    }
}
// }}}

