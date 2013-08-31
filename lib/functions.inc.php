<?php

require_once('globals.inc.php');

function getConnection() {
  $dbhost = DBHOST;
  $dbuser = DBUSER;
  $dbpass = DBPASS;
  $dbname = DBNAME;
  $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname",
                 $dbuser,
                 $dbpass,
                 array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}

// from http://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
function createPassword($email, $password) {
  // Create a 256 bit (64 characters) long random salt
  // Let's add 'something random' and the username
  // to the salt as well for added security
  $salt = hash('sha256', uniqid(mt_rand(), true) . $GLOBALS["salt"] . strtolower($email));

  // Prefix the password with the salt
  $hash = $salt . $password;

  // Hash the salted password a bunch of times
  for ( $i = 0; $i < 100000; $i ++ ) {
    $hash = hash('sha256', $hash);
  }

  // Prefix the hash with the salt so we can find it back later
  $hash = $salt . $hash;
  return $hash;
}

function validatePassword($password, $hashedPassword) {
  $isValid = FALSE;
  // The first 64 characters of the hash is the salt
  $salt = substr($hashedPassword, 0, 64);

  $hash = $salt . $password;

  // Hash the password as we did before
  for ( $i = 0; $i < 100000; $i ++ ) {
    $hash = hash('sha256', $hash);
  }

  $hash = $salt . $hash;

  if ( $hash == $hashedPassword ) {
    $isValid = TRUE;
  }

  return $isValid;
}