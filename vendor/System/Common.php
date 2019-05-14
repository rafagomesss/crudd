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

    public static function filterDataToReport(string $parentIndex, array $data)
    {
        $response[$parentIndex] = [];
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                foreach ($value as $innerKey => $innerValue) {
                    $response[$parentIndex][$innerKey][] = $innerValue;
                }
            }
        }

        foreach ($response[$parentIndex] as $key => $value) {
            $response[$parentIndex][$key] = "'" . implode("', '"  , $value) . "'";
        }

        ${$parentIndex} = new class($response[$parentIndex]) {

            public function __construct($attr)
            {
                foreach ($attr as $key => $value) {
                    $this->{$key} = $value;
                }
                return $this;
            }

        };

        return ${$parentIndex};
    }
}
