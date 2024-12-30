<?php 
namespace Timon\PhpFramework\Session;

class Session implements SessionInterface
{

    private const FLASH_KEY = 'flash';
    public function __construct()
    {
        session_start();
    }
    public function set(string $key, mixed $value)
    {
        $_SESSION[$key] =$value;
    }
    public function get(string $key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function setFlash(string $key, string $message)
    {
        $flash = $this->get(self::FLASH_KEY, []);
        $flash[$key][] = $message;
        $this->set(self::FLASH_KEY, $flash);
    }

    public function getFlash(string $key, $default = null)
    {
        $flash = $this->get(self::FLASH_KEY, []);

        if (isset($flash[$key])) {
            $messages = $flash[$key];
            unset($flash[$key]);
            $this->set(self::FLASH_KEY, $flash);

            return $messages;
        }
        return [];
    }

    public function hasFlash(string $key): bool
    {
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }

    public function clearFlash(): void
    {
        unset($_SESSION[self::FLASH_KEY]);
    }
}