<?php
namespace System\Session;

class Flash
{
    public static function set($key, $message)
    {
        Session::set($key, $message);
    }

    public static function get($key)
    {
        $message = Session::get($key);
        Session::delete($key);
        return $message;
    }
}
