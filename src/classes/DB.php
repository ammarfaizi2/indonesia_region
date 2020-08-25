<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 */
final class DB
{
  /**
   * @var \DB
   */
  private static $instance;

  /**
   * @var \PDO
   */
  private $pdo;

  /**
   * Constructor.
   */
  private function __construct()
  {
    $this->pdo = new PDO(...PDO_PARAM);
  }

  /**
   * @return \PDO
   */
  public static function pdo(): \PDO
  {
    return self::getInstance()->pdo;
  }

  /**
   * @return \DB
   */
  public static function getInstance(): \DB
  {

    if (!(self::$instance instanceof \DB)) {
      self::$instance = new self;
    }

    return self::$instance;
  }
}
