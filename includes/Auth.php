<?php

namespace SmartInvesting;

class Auth
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login($username, $password)
    {
        $admin = $this->db->fetch("SELECT * FROM admins WHERE username = ?", [$username]);
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            $_SESSION['admin_role'] = $admin['role'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_user']);
        unset($_SESSION['admin_role']);
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['admin_id']);
    }

    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header('Location: /admin/login.php');
            exit;
        }
    }
}
