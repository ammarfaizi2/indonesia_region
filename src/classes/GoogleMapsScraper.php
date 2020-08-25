<?php

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 */
abstract class GoogleMapsScraper
{
  /**
   * @var string
   */
  protected $cookieFile;

  /**
   * @param string $cookieFile
   *
   * Constructor.
   */
  public function __construct(string $cookieFile)
  {
    $this->cookieFile = $cookieFile;
  }

  /**
   * @param string $url
   * @param array  $opt
   * @return array
   */
  public function curl(string $url, array $opt = []): array
  {
    $optf = [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_USERAGENT      => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:78.0) Gecko/20100101 Firefox/78.0",
      CURLOPT_COOKIEFILE     => $this->cookieFile,
      CURLOPT_COOKIEJAR      => $this->cookieFile,
      CURLOPT_FOLLOWLOCATION => true,
    ];
    foreach ($opt as $k => $v) {
      $optf[$k] = $v;
    }

    $tryCount = 0;

    start_curl:
    $tryCount++;
    $ch = curl_init($url);
    curl_setopt_array($ch, $optf);
    $o = [
      "out"  => curl_exec($ch),
      "info" => curl_getinfo($ch),
      "err"  => curl_error($ch),
      "ern"  => curl_errno($ch),
    ];
    curl_close($ch);

    if ($o["err"] && ($tryCount <= 5)) {
      goto start_curl;
    }

    return $o;
  }

  /**
   * @param string $query
   * @return ?array
   */
  abstract public function getLatLong(string $query): ?array;
}
