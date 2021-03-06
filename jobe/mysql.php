<?php
$user = $argv[1];
$pass = $argv[2];

$mysqli = new mysqli("localhost", "root");

// Check connection
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

// Create database
$mysqli->query("CREATE DATABASE IF NOT EXISTS jobe");

// create user
$mysqli->query("CREATE USER IF NOT EXISTS '$user'@'localhost'IDENTIFIED BY '$pass'");
$mysqli->query("GRANT ALL PRIVILEGES ON jobe.* TO 'jobe'@'localhost'");

$mysqli->query("use jobe");

// CREATE "keys" table for API keys
$mysqli->query("CREATE TABLE IF NOT EXISTS `keys` ( 
       `id` INT(11) NOT NULL AUTO_INCREMENT,
       `user_id` INT(11) NOT NULL,
       `key` VARCHAR(40) NOT NULL,
       `level` INT(2) NOT NULL,
       `ignore_limits` TINYINT(1) NOT NULL DEFAULT '0',
       `is_private_key` TINYINT(1)  NOT NULL DEFAULT '0',
       `ip_addresses` TEXT NULL DEFAULT NULL,
       `date_created` INT(11) NOT NULL,
       PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

$result = $mysqli->query("DROP TRIGGER IF EXISTS before_keys_insert");

if ($result === TRUE) {
  echo "Trigger deleted! \r\n";
} else {
  echo "Error deleting trigger: " . $mysqli->error . ` \n`;
}

$result = $mysqli->query("CREATE TRIGGER before_keys_insert BEFORE INSERT ON jobe.keys
                            FOR EACH ROW
                            BEGIN
                              IF (NEW.user_id IS NULL) THEN 
                                SET NEW.user_id = 123456; 
                              END IF; 
                              SET NEW.level = 1;
                              SET NEW.date_created = UNIX_TIMESTAMP();
                            END;");

if ($result === TRUE) {
  echo "Trigger created! \r\n";
} else {
  echo "Error creating trigger: " . $mysqli->error . ` \r\n`;
}

// INSERT sample api key for testing
$sql = "DELETE FROM jobe.keys WHERE keys.key = 'dcc9a835-9750-4725-af5b-2c839908f71'";
$mysqli->query($sql);

$sql = "INSERT INTO jobe.keys (`key`) VALUES ('dcc9a835-9750-4725-af5b-2c839908f71')";
$insert = $mysqli->query($sql);

if ($insert === TRUE) {
  echo "Sample API key inserted! \r\n";
} else {
  echo "Error: " . $sql . "<br>" . $mysqli->error . ` \r\n`;
}

// CREATE "logs" table
$mysqli->query("CREATE TABLE IF NOT EXISTS `logs` (
       `id` INT(11) NOT NULL AUTO_INCREMENT,
       `uri` VARCHAR(255) NOT NULL,
       `method` VARCHAR(6) NOT NULL,
       `params` MEDIUMTEXT DEFAULT NULL,
       `api_key` VARCHAR(40) NOT NULL,
       `ip_address` VARCHAR(45) NOT NULL,
       `time` INT(11) NOT NULL,
       `rtime` FLOAT DEFAULT NULL,
       `authorized` VARCHAR(1) NOT NULL,
       `response_code` smallint(3) DEFAULT '0',
       PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

// CREATE "limits" table
$mysqli->query("CREATE TABLE IF NOT EXISTS `limits` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `uri` VARCHAR(255) NOT NULL,
  `count` INT(10) NOT NULL,
  `hour_started` INT(11) NOT NULL,
  `api_key` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8");

$mysqli->close();
