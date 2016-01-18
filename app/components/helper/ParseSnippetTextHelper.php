<?php

/**
 *
 */
class ParseSnippetTextHelper
{
    /**
     *  解析程式碼片段格式
     *  格式說明請查閱文件
     */
    public static function parse($path)
    {
        if (!file_exists($path)) {
            echo 'Error: parse path not found!';
            exit;
        }

        $items = [];
        foreach (glob($path."/*.htm")  as $file) {
            $text = file_get_contents($file);
            $item = self::anatomiseText($text);
            $item['attrib'] = self::anatomiseAttrib($item['attrib']);
            $items[] = $item;
        }

        return $items;
    }

    /**
     *  將文章解剖為四個部份
     *      - id (unique by header)
     *      - header
     *      - attrib
     *      - body
     */
    private static function anatomiseText($text)
    {
        $item = array_flip(['id','header','attrib','body']);

        //
        $formatTmp = explode("\n\r", $text);

        //
        $headerTmp = explode("\n", trim($formatTmp[0]));
        $item['header'] = trim($headerTmp[0]);
        $hash = md5($item['header']);
        $item['id'] = substr($hash, 0, 6);

        //
        unset($headerTmp[0]);
        $item['attrib'] = $headerTmp;

        //
        unset($formatTmp[0]);
        $item['body'] = join("\n", $formatTmp);

        return $item;
    }

    /**
     *  解剖 attrib array
     */
    private static function anatomiseAttrib(Array $items)
    {
        $result = [];
        foreach ($items as $item) {
            $attribKeyAndValue = explode(':', $item);
            if (2 !== count($attribKeyAndValue)) {
                continue;
            }
            list($key, $value) = $attribKeyAndValue;
            $key = trim($key);
            $value = trim($value);
            if (!$key || !$value) {
                continue;
            }
            $result[$key] = $value;
        }

        return $result;
    }

}
