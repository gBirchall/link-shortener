<?php
require 'autoload.php';

class LinkController
{
    public static function generateLink(string $url): string
    {
        //remove the protocol from the url if it exists
        if (preg_match('/^http(s)?:\/\//', $url)) {
            $url = preg_replace('/^http(s)?:\/\//', '', $url);
        }

        //then validate url using regex
        if (!self::validateLink($url)) {
            //if not valid, return 400 
            http_response_code(400);
            return "URL is not valid";
        }

        //generate short url - 5 random characters
        $shortUrl = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

        $db = new DatabaseController();
        $insert = $db->insertUrl($url, $shortUrl);

        if (!$insert) {
            http_response_code(400);
            return "URL could not be inserted into database. Please check your database connection.";
        }
        return $_ENV['APP_URL'] . '/' .  $shortUrl;
    }

    /*
    * Helper function validate url rather than using filter_var()
    */
    public static function validateLink($url): bool
    {
        $regex = "((https?|ftp)\:\/\/)?";
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
        $regex .= "(\:[0-9]{2,5})?";
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";

        return preg_match("/^$regex$/i", $url) ? true : false;
    }
}
