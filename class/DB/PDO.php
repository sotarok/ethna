<?php
/**
 *  PDO.php
 *
 *  @author     Sotaro KARASAWA <sotarok@crocos.co.jp>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 */

/**
 *
 *  @author     Sotaro KARASAWA <sotarok@crocos.co.jp>
 *  @package    Ethna
 */
class Ethna_DB_PDO extends Ethna_DB
{
    /**
     *  'phptype' => string 'mysql' (length=5)
     *  'dbsyntax' => string 'mysql' (length=5)
     *  'username' => string 'root' (length=4)
     *  'password' => string 'hoge' (length=4)
     *  'protocol' => string 'tcp' (length=3)
     *  'hostspec' => string 'localhost' (length=9)
     *  'port' => boolean false
     *  'socket' => boolean false
     *  'database' => string 'want' (length=4)
     */
    protected $dsninfo;

    public function __construct($controller, $dsn, $persistent)
    {
        parent::__construct($controller, $dsn, $persistent);
        // TODO: DSN を Ethna の DSN として共通化する？
        // そもそもDSN形式で有る必要がないので $dsn に配列を渡す前提とする

        $this->db = null;
        $this->logger = $controller->getLogger();
        $this->sql = $controller->getSQL();

        $this->dsninfo = $this->parseDSN($dsn);
    }

    /**
     *  DBに接続する
     *
     *  @access public
     *  @return mixed   0:正常終了 Ethna_Error:エラー
     */
    function connect()
    {
        $spec = array();
        $spec[] = "dbname={$this->dsninfo['database']}";
        if ($this->dsninfo['socket']) {
            $spec[] = "socket={$this->dsninfo['socket']}";
        }
        if ($this->dsninfo['hostspec']) {
            $spec[] = "host={$this->dsninfo['hostspec']}";
        }
        if ($this->dsninfo['port']) {
            $spec[] = "port={$this->dsninfo['port']}";
        }

        $username = null;
        if ($this->dsninfo['username']) {
            $username = $this->dsninfo['username'];
        }
        $password = null;
        if ($this->dsninfo['password']) {
            $password = $this->dsninfo['password'];
        }
        // dsninfo
        $dsn = sprintf('%s:%s', $this->dsninfo['phptype'], implode(';', $spec));
        try {
            $db = new PDO($dsn, $username, $password);
            $this->db = $db;
        } catch (Exception $e) {
            $this->logger->log(LOG_ERR, "Error: " . $e->getMessage());
        }

    }

    public function prepare($query)
    {
        $this->prepared_statement = $this->db->prepare($query);
        return $this;
    }

    public function execute($var)
    {
        $result = $this->prepared_statement->execute($var);
        if (!$result) {
            $errinfo = $this->prepared_statement->errorInfo();
            Ethna::raiseError("Error: " . $errinfo[2]);
            return false;
        }
        return $this->prepared_statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *  DB接続を切断する
     *
     *  @access public
     */
    function disconnect()
    {
    }

    /**
     *  DB接続状態を返す
     *
     *  @access public
     *  @return bool    true:正常(接続済み) false:エラー/未接続
     */
    function isValid()
    {
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     *  DBトランザクションを開始する
     *
     *  @access public
     *  @return mixed   0:正常終了 Ethna_Error:エラー
     */
    function begin()
    {
        return $this->db->beginTransaction();
    }

    /**
     *  DBトランザクションを中断する
     *
     *  @access public
     *  @return mixed   0:正常終了 Ethna_Error:エラー
     */
    function rollback()
    {
        return $this->db->rollback();
    }

    /**
     *  DBトランザクションを終了する
     *
     *  @access public
     *  @return mixed   0:正常終了 Ethna_Error:エラー
     */
    function commit()
    {
        return $this->db->commit();
    }

    /**
     *  テーブル定義情報を取得する
     *
     *  @access public
     *  @return mixed   array: PEAR::DBに準じたメタデータ
     *                  Ethna_Error::エラー
     */
    function getMetaData()
    {
        //   このメソッドはAppObject
        //   との連携に必要。
    }

    /**
     *  DSNを取得する
     *
     *  @access public
     *  @return string  DSN
     */
    function getDSN()
    {
        return $this->dsn;
    }

    public function query($query)
    {
        if (($result = $this->db->query($query)) === false) {
            $errorinfo = $this->db->errorInfo();
            return Ethna::raiseError("Error: message='{$errorinfo[2]}', code={$errorinfo[0]}, vendorcode={$errorinfo[1]}");
        }
        return $result;
    }
}
