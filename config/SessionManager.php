<?php
namespace Demetech;

class SessionManager {
    private static $sessionStarted = false;

    public static function start() {
        if (!self::$sessionStarted && session_status() == PHP_SESSION_NONE) {
            session_start();
            self::$sessionStarted = true; // session démarrée
        }
    }

    public static function destroy() {
        if (self::$sessionStarted && session_status() != PHP_SESSION_NONE) {
            session_unset();
            session_destroy();
            self::$sessionStarted = false; // session détruite
        }
    }
}
?>