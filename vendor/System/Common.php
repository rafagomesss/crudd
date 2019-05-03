<?php
namespace System;

class Common
{
    public static function convertDateToDataBase($date)
    {
        $aux = explode('/', $date);
        $aux = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $dateTime = new \DateTime($aux, new \DateTimezone("America/Sao_Paulo"));
        return $dateTime->format('Y-m-d');
    }
}
