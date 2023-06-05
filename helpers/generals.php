<?php

function debugging($variable): void {
  echo "<pre>";
  var_dump($variable);
  echo "</pre>";
  exit;
}

function sanitize(string $html = ''): string {
  $sanitized = htmlspecialchars($html);
  return $sanitized;
}

function isFinal(string $currency, string $next): bool {
  if ($currency !== $next) {
    return true;
  }
  return false;
}

function isAuth(): bool {
  if (!isset($_SESSION)) session_start();
  
  return isset($_SESSION['login']);
}

function isAdmin(): bool {
  if (!isset($_SESSION)) session_start();

  return isset($_SESSION['admin']);
}

function isLinkActive(string $link): bool {
  $current = $_SERVER['REQUEST_URI'];
  $current = explode('?', $current)[0];

  return ($current === $link);
}