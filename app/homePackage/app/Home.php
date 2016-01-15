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
        $parseText  = file_get_contents( conf('app.path') . '/src/parse.txt' );
        $template   = file_get_contents( conf('app.path') . '/src/template.htm' );
        self::removeAllbuildTemplateFile();

        $items = \ParseSnippetTextHelper::parse($parseText);

        // build list
        $list = '';
        foreach ($items as $item) {
            $list .= '<a class="list-group-item js-light" data-id="'. $item['id'] .'" href="_'. $item['id'] .'.htm#'. $item['id'] .'">'. $item['header'] .'</a>';
        }

        // add item list to template
        $template = str_replace('{{$list}}', $list, $template);

        // build _index.htm
        $buildContent = str_replace('{{$content}}','', $template);
        $buildFile = conf('app.path') . "/home/_index.htm";
        file_put_contents($buildFile, $buildContent);

        // build other templates
        foreach ($items as $item) {
            $buildContent = str_replace('{{$content}}', $item['body'], $template);
            $buildFile = conf('app.path') . "/home/_{$item['id']}.htm";
            file_put_contents($buildFile, $buildContent);
        }

        echo "Build Finel\n";
    }

    private function removeAllbuildTemplateFile()
    {
        $basePath = conf('app.path') . "/home";
        if (!file_exists($basePath.'/_index.htm')) {
            echo 'Error: "_index.htm"not found!';
            exit;
        }
        
        foreach (glob($basePath."/_*.htm")  as $file) {
            unlink($file);
        }
    }

}
