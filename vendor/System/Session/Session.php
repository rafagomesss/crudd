<?php
namespace System\Session;

use System\Connection;

class Session implements \SessionHandlerInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_save_handler($this, true);
            session_start();
        }
    }

    public function open($path, $session_name): bool
    {
        if ($this->db) {
            return true;
        }
        return false;
    }

    public function close()
    {
        $this->db = null;
        if (is_null($this->db)) {
            return true;
        }
        return false;
    }

    public function read($sessionId): string
    {
        if (!$this->db) {
            $this->db = Connection::getInstance();
        }

        $sql = "SELECT data FROM sessions WHERE session_id = :session_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch()->data;
        }
        return '';

    }

    public function write($sessionId, $data): bool
    {
        $access = time();
        $sql = "SELECT * FROM sessions WHERE session_id = :session_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':session_id', $sessionId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE sessions SET access_at = :access_at, data = :data WHERE session_id = :session_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':access_at', $access);
            $stmt->bindParam(':session_id', $sessionId);
            $stmt->bindParam(':data', $data);
            if ($stmt->execute()) {
                return true;
            }
        } else {
            $sql = "INSERT INTO sessions(session_id, access_at, data) VALUES (:session_id, :access_at, :data)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':session_id', $sessionId);
            $stmt->bindValue(':access_at', $access);
            $stmt->bindParam(':data', $data);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function destroy($sessionId): bool
    {
        $sql = 'DELETE FROM sessions WHERE session_id = :session_id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':session_id', $sessionId);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function gc($maxlifetime): bool
    {
        echo '<pre>' . print_r('here', 1) . '</pre>';exit;
        $old = time() - $maxlifetime;

        $sql = "DELETE FROM sessions WHERE access_at < :old";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':old', $maxlifetime);

        if ($this->db->execute()) {
            session_gc();
            return true;
        }
        return false;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function delete(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function destroySession()
    {
        session_destroy();
    }

    public static function validateSessionUser()
    {
        return self::has('USER') && self::has('ACCESS_LEVEL');
    }
}
