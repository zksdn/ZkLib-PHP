# ZkLib PHP (SOAP AND UDP protocol)
Communication between PHP language and ZK Time Attendance Devices (RFID, fingerprint, etc.).

#About
To interacts with ZK Time Attendance Devices with PHP.<br/>
ZkLib use SOAP and UDP protocols.<br/>

Some methods use the SOAP protocol:<br/>
For example => add user, remove user, extraction of users log, etc.<br/>
<br/>
And some methods use the UDP protocol:<br/>
For example => getDeviceName, free size, restart, unlock the door, etc.<br/>
<br/>
The implementation of the class UdpZkClient.php is the same implementation of this class in TADZKLib.php in this repositorie https://github.com/cobisja/tad-php <br/>
Special thanks to Jorge Cobis !<br/>

#Demo

> $host = 0.0.0.0;<br/>
> $zklib = new ZkLib($host);<br/>
> $serial_number = $zklib->getSerialNumber();<br/>
