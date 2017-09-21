<?php

include_once(__DIR__ . '/../global.php');
include_once(__DIR__ . '/abstract/Singleton.php');

class Connection extends Singleton {

  private $con;

  private function genMySqlDsnFromEnv($dbInfo) {
    if (!key_exists('mysql', $dbInfo)) {
      return FALSE;
    }
    $dbInfo = $dbInfo['mysql'];

    return (
      "mysql:" .
      (empty($dbInfo['host'])
        ? "unix_socket=$dbInfo[unix_socket]"
        : ("host=$dbInfo[host]" .
           (empty($dbInfo['port']) ? '' : ";port=$dbInfo[port]"))
      ) .
      ";dbname=$dbInfo[database]" .
      (empty($dbInfo['charset']) ? '' : ";charset=$dbInfo[charset]")
    );
  }

  protected function __construct() {
    if (!key_exists('DATABASE_INFO', $GLOBALS)) {
      throw new UnexpectedValueException(
        "Failed to get database info, incorrect ENVIRONMENT data"
      );
    }

    // TODO: Add more drivers
    $dns = $this->genMySqlDsnFromEnv($GLOBALS['DATABASE_INFO']) ?? NULL;

    if (is_null($dns)) {
      throw new Exception(
        "Couldn't open database connection. " .
        "Maybe the defined driver isn't yet supported."
      );
    }

    $this->con = new PDO(
      $dns,
      $GLOBALS['DATABASE_INFO']['user'],
      $GLOBALS['DATABASE_INFO']['password']
    );
  }

  public function query($query, array $data = []) {
    $stmt = $this->con->prepare($query);
    return $stmt->execute($data) ? $stmt : NULL;
  }
}
