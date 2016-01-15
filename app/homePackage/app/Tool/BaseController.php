<?php
namespace AppModule\Tool;

/**
 *
 */
class BaseController
{

    /**
     *
     */
    public function __call($method, $args)
    {
        if (!method_exists($this, $method)) {
            throw new \Exception("API method '{$method}' is not exist!");
            exit;
        }
        $this->loadHelper($args);
        $this->$method();
    }

    /**
     *  load functions, to help controller
     *
     *  裡面包裹的 help function
     *  僅給 controller 使用
     *  並不給予 view 使用
     */
    protected function loadHelper(Array $args)
    {
        if (isCli()) {
            // TODO: 找時間對 console 指令的格式, 做解析
            return;
        }
        $request  = $args[0];
        $response = $args[1];
        $args     = $args[2];
        LoadHelper::init($request, $response, $args);
    }

}
