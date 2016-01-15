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
    public static function parse($text)
    {
        $items = self::anatomiseText($text);
        foreach ($items as $index => $item) {
            $items[$index]['attrib'] = self::anatomiseAttrib($item['attrib']);
        }

        // 給予一個 unique id
        foreach ($items as $index => $item) {
            $hash = md5($item['header']);
            $items[$index]['id'] = substr($hash, 0, 6);
        }
        return $items;
    }

    /**
     *  將文章解剖為三個部份
     *      - header
     *      - attrib
     *      - body
     */
    private static function anatomiseText($text)
    {
        $contents = explode("----", $text);
        $contents = array_filter($contents, function($val){
            if(''===$val) {
                return false;
            }
            return true;
        });

        $items = [];
        foreach ($contents as $content) {
            $item = [];

            //
            $formatTmp = explode("\n\r", $content);

            //
            $headerTmp = explode("\n", trim($formatTmp[0]));
            $item['header'] = trim($headerTmp[0]);

            //
            unset($headerTmp[0]);
            $item['attrib'] = $headerTmp;

            //
            unset($formatTmp[0]);
            $item['body'] = join("\n", $formatTmp);
            
            $items[] = $item;
        }
        return $items;
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
