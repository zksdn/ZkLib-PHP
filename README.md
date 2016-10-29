# ZkLib PHP (SOAP AND UDP protocol)
Communication between PHP language and ZK Time Attendance Devices (RFID, fingerprint, etc.).

#About
To interacts with ZK Time Attendance Devices with PHP
ZkLib use SOAP and UDP protocols.

Some methods use the SOAP protocol:
For example => add user, remove user, extraction of users log, etc.

And some methods use the UDP protocol:
For example => getDeviceName, free size, restart, unlock the door, etc.

The implementation of the class UdpZkClient.php is the same implementation of this class in TADZKLib.php in this repositorie https://github.com/cobisja/tad-php
special thanks to Jorge Cobis !

#Demo

$host = 0.0.0.0;
$zklib = new ZkLib($host);
$serial_number = $zklib->getSerialNumber();
