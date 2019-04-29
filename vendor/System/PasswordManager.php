<?php
namespace System;

class PasswordManager
{
    public static function passwordHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
    }

    public static function validatePassword($password, $hash)
    {
        if (password_verify($password, $hash)) {
            return true;
        }
        return false;
    }
}
