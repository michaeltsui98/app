<?php

require_once COLA_DIR . '/Com/Search/lib/XS.php';

class Cola_Com_Search
{

    /**
     * $_config array
     *
     * @var string $_file xunSearch configuration ini file path
     * @var string charset DefaultCharset
     */
    private $_config;

    /**
     * XS object
     * @var type object
     */
    private $_search = null;
    private $_tokenizer = null;

    public function __construct($config = array())
    {
        $this->_config = $config + array('file' => 'wenku', 'charset' => 'UTF-8');
        $this->getInstance();
    }

    /**
     * instance search at XS
     * @return object
     */
    private function getInstance()
    {
        if (null == $this->_search) {
            $this->_search = new XS($this->_config['file']);
            $this->_search->setDefaultCharset($this->_config['charset']);
        }
        return $this;
    }

    /**
     * return tokenizer
     */
    public function getTokenizer()
    {
        if (null == $this->_tokenizer) {
            $this->_tokenizer = new XSTokenizerScws;
        }

        return $this->_tokenizer;
    }

    /**
     * return xun search object
     */
    public function getSearch()
    {
        return $this->_search;
    }

    /**
     * get search result by key
     * @param string $key search by key
     * @param string $type search type eg. blog, group, class, school
     * @return mixed
     */
    public function get($key, $type = null)
    {

        $key = 'obj_id:'. $key;
         
        return $this->_search->search->search($key);
    }

    /**
     *
     * @param string $key
     * @param string $sendType
     * @return mixed
     */
    public function getBySendType($key, $sendType = null)
    {

        null != $sendType && $key = 'sendType:' . $sendType . ' ' . $key;

        return $this->_search->search->search($key);
    }

 /**
  * update to search db
  * @param string $obj_id
  * @param string $doc_title
  * @param string $doc_content
  * @param string $obj_node
  * @param string $know_node
  * @param string $user_name
  * @param string $user_id
  * @param string $doc_summery
  * @param string $time
  * @return boolean
  */
    public function set($data= array(),$add=true)
    {
        try {
            
            $doc = new XSDocument;
            
            $doc->setFields($data);

            $this->_search->index->update($doc,$add);
            return TRUE;
        } catch (Exception $exc) {

            throw  $exc;
        }
    }

    /*
     * delete data for search
     * @param array $ids
     * @param string $type
     */

    public function delete($ids, $type = null)
    {
        try {
            if (null != $type) {
                $this->_search->index->del($ids, $type);
            } else {
                $this->_search->index->del($ids);
            }

            return TRUE;
        } catch (Exception $exc) {

            throw $exc;
        }
    }

}