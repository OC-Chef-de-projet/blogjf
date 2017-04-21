<?php
namespace App\Model;

/**
  	CREATE TABLE IF NOT EXISTS `comment` (
		`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`episode_id` int(11) NOT NULL,
  		`parent_id` int(11) NOT NULL DEFAULT '0',
  		`depth` int(11) NOT NULL DEFAULT '0',
  		`content` text NOT NULL,
  		`author` varchar(64) NOT NULL,
  		`email` text NOT NULL,
  		`abuse` tinyint(1) NOT NULL DEFAULT '0',
  		`created` date DEFAULT NULL,
  		`modified` date DEFAULT NULL
	);
*/

class Comment extends \Core\Model
{


}
