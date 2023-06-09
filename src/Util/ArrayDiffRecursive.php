<?php

declare(strict_types=1);

namespace WPRestClient\Util;

class ArrayDiffRecursive
{
    /**
     * @param $aArray1
     * @param $aArray2
     * @return array
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public static function diff($aArray1, $aArray2): array
    {
        $aReturn = [];

        foreach ($aArray1 as $mKey => $mValue) {
            if (array_key_exists($mKey, $aArray2)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = self::diff($mValue, $aArray2[$mKey]);
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue != $aArray2[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }
        return $aReturn;
    }
}
