<?php

namespace SmartInvesting;

class Core
{
    public function __construct()
    {
        // Start session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize database if config exists
        if (file_exists(__DIR__ . '/../config/database.php')) {
            require_once __DIR__ . '/../config/database.php';
            require_once __DIR__ . '/Database.php';
        }

        // Load helpers
        require_once __DIR__ . '/Functions.php';
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');

        // Simple router logic
        if (empty($uri)) {
            $this->renderTemplate('home');
        } elseif (preg_match('/^admin/', $uri)) {
            $this->handleAdmin($uri);
        } else {
            $this->renderPage($uri);
        }
    }

    private function renderTemplate($name)
    {
        $file = __DIR__ . '/../templates/' . $name . '.php';
        if (file_exists($file)) {
            include $file;
        } else {
            echo "404 - Template not found";
        }
    }

    private function renderPage($slug)
    {
        // Fetch page from database and render
        echo "Rendering page: " . htmlspecialchars($slug);
    }

    private function handleAdmin($uri)
    {
        // Handle admin routes
        echo "Admin area: " . htmlspecialchars($uri);
    }
}
