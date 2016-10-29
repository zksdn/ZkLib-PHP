<?php

namespace Pointeuse\Provider;

class SoapZkClient extends \SoapClient {

    private $filter_enabled = false;

    public function getFilter_enabled() {
        return $this->filter_enable;
    }

    public function setFilter_enabled($filter_enabled) {
        $this->filter_enabled = $filter_enabled;
    }

    public function correctXml($data) {


        $allowChar = array("\r", "\n", " ");


        for ($i = 0; $i < strlen($data); $i++) {
            if ($data[$i] == ">") {
                for ($j = $i + 1; $j < strlen($data); $j++) {
                    if (($data[$j] == "<" && $data[$j + 1] == "/") || ($data[$j] == "<" && ($data[$j - 1] == ">" || $data[$j - 1] == "\n"))) {
                        break;
                    } else if (!ctype_alnum($data[$j]) && !in_array($data[$j], $allowChar)) {
                        $data[$j] = "*";
                    }
                }
            }
        }
        return $data;
    }

    public function __doRequest($req, $location, $action, $version = SOAP_1_1) {

        $original_response = (parent::__doRequest($req, $location, $action, $version));
        if ($this->filter_enabled) {
            return str_replace("*", "", $this->correctXml($original_response));
        }
        return $original_response;
    }

}
