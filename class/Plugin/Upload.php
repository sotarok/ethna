<?php
// vim: foldmethod=marker
/**
 *  Upload.php
 *
 *  @author     Sotaro KARASAWA <sotarok@crocos.co.jp>
 *  @package    Ethna
 */

// {{{ Ethna_Plugin_Upload
/**
 *  ファイルアップロード
 *
 *  @author     Sotaro KARASAWA <sotarok@crocos.co.jp>
 *  @package    Ethna
 */
class Ethna_Plugin_Upload extends Ethna_Plugin_Abstract
{
    /**#@+
     *  @access private
     */


    /** @var    array   plugin configure */
    protected $config_default = array(
        'path'      => 'upload',
        'handler'   => 'localfile',
    );

    /**#@-*/

    /**
     *  トークンIDを削除する
     *
     *  @access public
     *  @return string トークンIDを返す。
     */
    public function setFile()
    {
    }

    /**
     *  トークン名を取得する
     *
     *  @access public
     *  @return string トークン名を返す。
     */
    public function save()
    {
        return $this->token_name;
    }

    /**
     *  Validation file
     *
     *  @access public
     *  @return mixed  正常の場合はtrue, 不正の場合はfalse
     */
    public function validate()
    {
    }

}
// }}}
