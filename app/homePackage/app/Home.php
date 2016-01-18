<?php
namespace AppModule;

/**
 *
 */
class Home extends Tool\BaseController
{

    /**
     *  
     */
    protected function build()
    {
        $parsePath    = conf('app.path') . "/src/parse";
        $templatePath = conf('app.path') . '/src/template.htm';

        $items        = \ParseSnippetTextHelper::parse($parsePath);
        $template     = file_get_contents($templatePath);
        self::removeAllbuildTemplateFile();


        // build list
        $list = '';
        foreach ($items as $item) {
            $list .= '<a class="list-group-item js-light" data-id="'. $item['id'] .'" href="_'. $item['id'] .'.htm#'. $item['id'] .'">'. $item['header'] .'</a>';
        }

        // add item list to template
        $template = str_replace('{{$list}}', $list, $template);

        // build other templates
        foreach ($items as $item) {
            $buildContent = str_replace('{{$content}}', $item['body'], $template);
            $buildFile = conf('app.path') . "/home/_{$item['id']}.htm";
            file_put_contents($buildFile, $buildContent);
        }

    }

    /**
     *
     */
    private function removeAllbuildTemplateFile()
    {
        $homePath = conf('app.path') . "/home";
        if (!file_exists($homePath)) {
            echo 'Error: home path not exist!';
            exit;
        }
        
        foreach (glob($homePath."/_*.htm")  as $file) {
            unlink($file);
        }
    }

}
