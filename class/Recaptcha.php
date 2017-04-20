<?php

/**
 * Class Recaptcha
 */
class Recaptcha
{
    private $api_secret;
    private $api_site;
    private $language;
    private $remoteip;

    /**
     * Constructor
     * @param $api_site
     * @param $api_secret
     * @param $language
     */
    public function __construct($api_site, $api_secret, $language='fr')
    {
        $this->api_secret = $api_secret;
        $this->api_site = $api_site;
        $this->language = $language;
        $this->remoteip = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Generate html
     * @return string
     */
    public function getHtml()
    {
        return '<div class="g-recaptcha" data-sitekey="' . $this->api_site . '"></div>';
    }

    /**
     * Generate script
     * @return string
     */
    public function getJs()
    {
        return '<script src="https://www.google.com/recaptcha/api.js?hl='.$this->language.'"></script>';
    }

    /**
     * Recaptcha Validation
     * @param $code
     * @return bool
     */
    public function isValid($code)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $post_data = "secret=" . $this->api_secret . "&response=" . $code . "&remoteip=" . $this->remoteip;

        if (function_exists('curl_version'))
        {
            $curl = curl_init($url.'?'.$post_data);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        }
        else
        {
            $response = file_get_contents($url);
        }
    
        if (empty($response) || is_null($response))
        {
            return false;
        }
    
        $json = json_decode($response);
        return $json->success;
    }
}
