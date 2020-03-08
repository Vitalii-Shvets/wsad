<?php


class View
{
    private static $folder = 'views';

    private static function includeParser($template, $data = array())
    {
        preg_match_all('/\<\%(.*?)\%\>/is', $template, $res);
        if ($res[1]) {
            foreach ($res[1] as $el) {
                $template = str_ireplace('<%' . $el . '%>', self::render($el, $data), $template);
            }
        }
        return $template;
    }

    public static function render($template, $data = array())
    {
        $content = file_get_contents(self::$folder . "/{$template}.html");
        $content = self::designRenderText($content, $data);

        return $content;
    }

    private static function designRenderText($content, $data = array())
    {
        $content = self::includeParser($content, $data);
        $content = self::designParseFunction($content, $data);
        $content = self::designParse($content, $data);

        return $content;
    }

    private static function designParseFunction($content, $data = array())
    {
        preg_match_all('/\<\<(.*?)\>\>/is', $content, $res);

        if ($res[1]) {
            foreach ($res[1] as $el) {
                $middle = self::designParse($el, $data);
                $middle = '$result = ' . $middle . ';';
                eval($middle);

                $content = str_ireplace('<<' . $el . '>>', $result, $content);
            }
        }
        return $content;
    }

    private static function designParse($content, $data)
    {
        preg_match_all('/\%\%(.*?)\%\%/si', $content, $res);

        if ($res[1]) {
            foreach ($res[1] as $el) {
                $content = str_ireplace("%%$el%%", $data[$el], $content);
            }
        }

        return $content;
    }
}
