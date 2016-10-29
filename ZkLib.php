<?php

namespace ZK;

class ZkLib {

    private $soapClient;
    private $udpClient;

    public static function checkState($host) {
        if ($pf = @fsockopen($host, 80, $err, $err_string, 1)) {
            $result = true;
            fclose($pf);
        } else {
            $result = false;
        }
        return $result;
    }

    public function __construct($host) {
        $soap_options = [
            'location' => "http://" . $host . "/iWsService",
            'uri' => 'http://www.zksoftware/Service/message/',
            'encoding' => 'UTF-8',
            'exceptions' => false,
            'trace' => true
        ];

        $udp_option = [
            'connection_timeout' => 5,
            'port' => 4370,
            'host' => $host,
            'encoding' => 'utf-8',
        ];
        $this->soapClient = new SoapZkClient(null, $soap_options);
        $this->udpClient = new UdpZkClient($udp_option);
    }

    public function getDate() {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $objectresult = $this->soapClient->GetDate($param);
        return($objectresult);
    }

    public function setDate($date, $time) {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $param->Arg = new \stdClass();
        $param->Arg->Date = $date;
        $param->Arg->Time = $time;
        $objectresult = $this->soapClient->SetDate($param);
        return($objectresult);
    }

    public function getUser($pin = null) {
        $this->soapClient->setFilter_enabled(true);
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $param->Arg = new \stdClass();
        $param->Arg->PIN = $pin;
        $objectresult = $this->soapClient->GetUserInfo($param);
        $this->soapClient->setFilter_enabled(false);
        return($objectresult);
    }

    public function getAttLog($pin = null) {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $param->Arg = new \stdClass();
        $param->Arg->PIN = $pin;
        $objectresult = $this->soapClient->GetAttLog($param);
        return($objectresult);
    }

    public function setUser($user) {
        $this->deleteUser($user->PIN2);
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $param->Arg = new \stdClass();
        $param->Arg->PIN2 = $user->PIN2;
        $param->Arg->Name = $user->Name;
        $param->Arg->Password = $user->Password;
        $param->Arg->Privilege = $user->Privilege;
        $param->Arg->Group = $user->Group;
        $param->Arg->Card = $user->Card;
        $param->Arg->TZ1 = $user->TZ1;
        $param->Arg->TZ2 = $user->TZ2;
        $param->Arg->TZ3 = $user->TZ3;
        $objectresult = $this->soapClient->SetUserInfo($param);
        $this->refreshDB();
        return($objectresult);
    }


    public function deleteUser($pin) {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $param->Arg = new \stdClass();
        $param->Arg->PIN = $pin;
        $objectresult = $this->soapClient->DeleteUser($param);
        $this->refreshDB();


        return($objectresult);
    }

    //value
    //1 : clear users
    //2 : clear user template
    //3 : clear attendance log
    public function clearData($value) {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $param->Arg = new \stdClass();
        $param->Arg->Value = $value;
        $objectresult = $this->soapClient->ClearData($param);
        return($objectresult);
    }

    public function refreshDB() {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $this->soapClient->RefreshDB($param);
    }


    public function getOption() {
        $param = new \stdClass();
        $param->ArgComKey = 0;
        $objectresult = $this->soapClient->GetOption($param);
        print_r($objectresult);
    }

    public function getDeviceName() {
        return($this->udpClient->get_device_name());
    }

    public function getSerialNumber() {
        return($this->udpClient->get_serial_number());
    }

    public function getFreeSize() {
        return($this->udpClient->get_free_sizes());
    }

    public function disable() {
        return($this->udpClient->disable());
    }

    public function restart() {
        return($this->udpClient->restart());
    }

    public function unlock() {
        return($this->udpClient->unlock());
    }

    public function enable() {
        return($this->udpClient->enable());
    }

}
