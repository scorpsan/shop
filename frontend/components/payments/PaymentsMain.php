<?php
namespace frontend\components\payments;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class PaymentsMain
{
    public static function MethodsList(): array
    {
        $check = "frontend\\components\\payments\\methods\\";

        $list = array();

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/methods/'));
        $regex    = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
        foreach ($regex as $file => $value) {
            $current = static::parseTokens(token_get_all(file_get_contents(str_replace('\\', '/', $file))));
            if ($current !== false) {
                list($namespace, $class) = $current;
                if($namespace === $check){
                    $nameclass = $namespace.$class;
                    $list += [$nameclass => $nameclass::name()];
                }
            }
        }

        return $list;
    }

    private static function parseTokens(array $tokens)
    {
        $nsStart    = false;
        $classStart = false;
        $namespace  = '';
        foreach ($tokens as $token) {
            if ($token[0] === T_CLASS) {
                $classStart = true;
            }
            if ($classStart && $token[0] === T_STRING) {
                return [$namespace, $token[1]];
            }
            if ($token[0] === T_NAMESPACE) {
                $nsStart = true;
            }
            if ($nsStart && $token[0] === ';') {
                $nsStart = false;
            }
            if ($nsStart && $token[0] === T_STRING) {
                $namespace .= $token[1] . '\\';
            }
        }

        return false;
    }

}