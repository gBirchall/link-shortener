<?php
require 'autoload.php';

class DatabaseController
{
    private static $db;

    public static function connect(): bool
    {
        try {

            self::$db = new mysqli(
                $_ENV['DB_HOST'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                $_ENV['DB_NAME']
            );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }


    public static function disconnect(): void
    {
        self::$db->close();
    }


    public  static function insertUrl(string $url, string $shortUrl): bool
    {
        if (!self::connect()) {
            return false;
        }
        $stmt = self::$db->prepare("INSERT INTO links (url, short_url, created) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $url, $shortUrl);
        $result = $stmt->execute();
        $stmt->close();
        self::disconnect();

        return true;
    }


    public static function checkUrl(string $url): string|false
    {
        if (!self::connect()) {
            return false;
        }
        $stmt = self::$db->prepare("SELECT * FROM links WHERE short_url = ?");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        self::disconnect();

        if ($result->num_rows > 0) {

            return $result->fetch_assoc()['url'];
        } else {
            return false;
        }
    }
}
