<?php
namespace App\Model;

/**
	CREATE TABLE IF NOT EXISTS `user` (
		`id` int(10) unsigned NOT NULL,
		`login` varchar(50) DEFAULT NULL,
		`password` varchar(255) DEFAULT NULL,
		`role` int(1) DEFAULT NULL,
		`created` datetime DEFAULT NULL,
		`modified` datetime DEFAULT NULL
	) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

*/

class User extends \Core\Model
{


}
