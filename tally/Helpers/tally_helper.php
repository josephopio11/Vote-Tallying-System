<?php
//--------------------------------------------------------------------

/**
 * All $namespaceUrl use this function for site_url
 * So you can change all url accoriding to your own router
 * 
 */
if (!function_exists('tally_url'))
{
    function tally_url($param = NULL, $locale = NULL)
    {
        if (empty($locale))
        {
            $locale = service('request')->getLocale();
        }

        return site_url("tally/$locale" . '/' . $param);
    }

}

//--------------------------------------------------------------------

if (!function_exists('resources_url'))
{

    /**
     * Resources Url
     * You can change to your resources url after download
     * https://resources.crud4.com/v1/v1.zip
     * @param string filename
     * @return string
     */
    function resources_url($filename = NULL)
    {
        return 'https://resources.crud4.com/v1/' . $filename;
        //return site_url('resources/' . $param);
    }

}

if (!function_exists('tally_assets'))
{
    function tally_assets($param = NULL)
    {
        return site_url('assets/tally/'. $param);
    }
}

//--------------------------------------------------------------------

if (!function_exists('tally_view'))
{
    function tally_view(string $name, array $data = [], array $options = []): string
    {
        $options['debug'] = false;

        return view('Tally\\' . $name, $data, $options);
    }

}

//--------------------------------------------------------------------

if (!function_exists('returnNumber'))
{
    function returnNumber($param): string
    {
        if (empty($param))
        {
            return "0.00";
        }
        if (is_numeric($param))
        {
            return $param;
        }

        $keywords = preg_split("/[,.]/", $param);
        $text     = '';

        if (count($keywords) > 1)
        {

            $last_element = end($keywords);

            if (strlen($last_element) == 0)
            {
                $last_element = "00";
            }
            for ($i = 0; $i < count($keywords) - 1; $i++)
            {
                if (strlen($keywords[$i]) > 0)
                {
                    $text = $text . $keywords[$i];
                }
            }
            $text += '.' . $last_element;
        }
        else
        {
            $text = $param;
        }

        if (strpos($text, ".") === FALSE)
        {
            return $text . ".00";
        }

        return ($text);
    }

}

//--------------------------------------------------------------------

if (!function_exists('getTemplateByName'))
{
    function getTemplateByName($templateName, $renderData = [])
    {
        $locale        = service('request')->getLocale();

        $C4_templateModel = new \Tally\Models\C4_templateModel();
        $C4_templateModel->where('name', $templateName);
        $C4_templateModel->where('lang', $locale);
        $C4_templateModel->where('status', 1);
        $templateData = $C4_templateModel->first();

        if (empty($templateData)) 
        {
            //Find another language temp..    
            $C4_templateModel->where('name', $templateName);
            $C4_templateModel->where('status', 1);
            $templateData = $C4_templateModel->first();
        }

        if (!empty($templateData) && !empty($renderData))
        {
            $parser               = \Config\Services::parser();
            $templateData['title'] = $parser->setData($renderData)->renderString($templateData['title']);
            $templateData['content'] = $parser->setData($renderData)->renderString($templateData['content']);
        }

        return $templateData;
    }
}

