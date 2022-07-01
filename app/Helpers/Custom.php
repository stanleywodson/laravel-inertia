<?php

namespace App\Helpers;

use Carbon\Carbon;

class Custom {

    CONST SELECIONE = '--Selecione--';

    public static function sanitizeDate($request)
    {
        $currentArrayDate = \explode('/',$request);
        $data = \join('-', array_reverse($currentArrayDate));
        $newData =  Carbon::parse($data)->format('Y-m-d H:i:s');
        return $newData;
    }

    public static function setValueTofloat($valor) 
    {
        $dotPos = strrpos($valor, '.');
        $commaPos = strrpos($valor, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $valor));
        }

        return floatval(
            preg_replace("/[^0-9]/", "", substr($valor, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($valor, $sep+1, strlen($valor)))
        );
    }


    public static function selectOption()
    {
        return "<option value=''>--Selecione--</option>";
    }

    public static function padString($string, $qnt = 8, $typeString = '0')
    {
        return  str_pad($string,$qnt,$typeString,STR_PAD_LEFT);
    }

    public static function calcPacela($parcela,$valorFin,$taxa = 1.4)
    {
        $total =  $valorFin *  ( ( (1 + $taxa) ^ ($parcela * $taxa) ) / ( (1+ $taxa) ^ ($parcela - 1) ) ) ;
        return $total / $parcela;
    }

    protected static function potencia($number1, $number2)
    {
        return pow($number1,$number2);
    }


    public static function findString($pattern,$subject)
    {
      preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
      return $matches;
    }

   

}
