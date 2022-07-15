<?php
require 'autoload.php';


class RedirectController
{
    public static function redirect(string $request): void
    {
        $result = DatabaseController::checkUrl($request);
        if ($result) {
            header('Location: http://' . $result);
        } else {
            http_response_code(404);
            echo '404 - Sorry this page does not exist';
        }
    }
}
