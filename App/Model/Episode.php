<?php
namespace App\Model;

/**
  	CREATE TABLE episode (
	    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	    title VARCHAR(50),
	    content TEXT,
	    created DATETIME DEFAULT NULL,
	    modified DATETIME DEFAULT NULL
	);
*/

class Episode extends \Core\Model
{


}
