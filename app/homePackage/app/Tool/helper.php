<?php
namespace AppModule;

// --------------------------------------------------------------------------------
// wrap controller help functions
// --------------------------------------------------------------------------------

/**
 *  取得 route 處理之後獲得的參數
 */
function attrib($key, $defaultValue=null)
{
    $val = Tool\LoadHelper::getRequest()->getAttribute($key);
    if (!$val) {
        $val = $defaultValue;
    }
    return $val;
}

/**
 *  輸出
 */
function put($message)
{
    if (is_array($message)) {
        $message = json_encode($message);
    }
    elseif (is_object($message)) {
        $toArray = (array) $message;
        $result = [];
        foreach ($toArray as $key => $value) {
            $result[$key] = $value;
        }
        $message = json_encode($result);
    }
    else {
        $message = json_encode([
            'result' => $message
        ]);
    }
    
    Tool\LoadHelper::getResponse()->getBody()->write($message);
}

function getSlimApp()
{
    global $app;
    return $app;
}