<?php
class API_SG
{
    private $_membreid;
    private $_codeactivation;
    private $_datas = array();
    private $_apiUrl = 'https://sg-autorepondeur.com/API_V2/';


    public function __construct($membreid, $codeactivation)
    {
        $this->_membreid        = $membreid;
        $this->_codeactivation  = $codeactivation;

        $this->_datas['membreid']       = $this->_membreid;
        $this->_datas['codeactivation'] = $this->_codeactivation;
    }

    public function set($name, $value = '')
    {
        if (is_array($name)) {
            foreach($name as $id => $value)
                $this->set($id, $value);
        } else {
            $this->_datas[$name] = $value;
        }
        return $this;
    }

    public function call($action)
    {
        $this->_datas['action'] = $action;
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($this->_datas)
            )
        );

        $context  = stream_context_create($options);
        $result = file_get_contents($this->_apiUrl, false, $context);
        if ($result === FALSE) {
            throw new Exception('Aucun résultat renvoyé par SG-Autorépondeur');
        }
        return $result;
    }
}