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

    public static function redirect($route)
    {
        header("Location: {$route}");
    }

    public static function removeEmptyValueArray(array $array = []): array
    {
        $retorno = $array;
        foreach ($retorno as $key => $value) {
            if (empty($value)) {
                unset($retorno[$key]);
            }
        }
        return $retorno;
    }
}
