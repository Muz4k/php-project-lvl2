<?php

function genDiff($pathToFile1, $pathToFile2)
{
    $result = [];
    $diffResult = [];

    $json1 = json_decode(file_get_contents(normalizePath($pathToFile1)), true);
    $json2 = json_decode(file_get_contents(normalizePath($pathToFile2)), true);
    $keysList = array_keys($json1 + $json2);

    foreach ($keysList as $key) {
        $value1 = isset($json1[$key]) ? toString($json1[$key]) : null;
        $value2 = isset($json2[$key]) ? toString($json2[$key]) : null;

        if ($value1 === $value2) {
            $result[$key] = "  {$key}: {$value1}";
            continue;
        }

        $diffResult[$key] = [$value1, $value2];
    }

    foreach ($diffResult as $key => $valueList) {
        $res1 = '';
        $res2 = '';

        if ($valueList[0] !== null) {
            $res1 = "- {$key}: {$valueList[0]}";
        }

        if ($valueList[1] !== null) {
            $res2 = "+ {$key}: {$valueList[1]}";
        }
        $result[$key] = trim($res1 . PHP_EOL . $res2);
    }

    ksort($result);

    return '{' . PHP_EOL . implode(PHP_EOL, $result) . PHP_EOL . '}';
}

function toString($value): string
{
    if (is_bool($value)) {
        return var_export($value, true);
    }

    return (string) $value;
}

function normalizePath($pathToFile): string
{
    if ($pathToFile[0] === '/') {
        return $pathToFile;
    }

    return __DIR__ . '/' . $pathToFile;
}