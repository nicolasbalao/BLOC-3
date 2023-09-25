<?php

namespace App\Utils;

/**
 * Class for handle message in the session and the starting of it 
 */
class SessionHelper
{
    /** Start
     * Start the session if not started yet 
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function setSuccessMessage($message)
    {
        self::start();
        $_SESSION["success"] = $message;
    }

    public static function setError($message)
    {
        self::start();
        $_SESSION["error"] = $message;
    }

    public static function getSuccessMessage()
    {
        self::start();
        if (isset($_SESSION["success"])) {
            $message = $_SESSION["success"];
            unset($_SESSION["success"]); // Clear the success message from the session after retrieving it
            return $message;
        }
        return null;
    }

    public static function getError()
    {
        self::start();
        if (isset($_SESSION["error"])) {
            $message = $_SESSION["error"];
            unset($_SESSION["error"]); // Clear the error message from the session after retrieving it
            return $message;
        }
        return null;
    }
}
