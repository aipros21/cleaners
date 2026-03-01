<?php
/**
 * Authentication & session management
 */
require_once __DIR__ . '/inc_db.php';

/**
 * Get current logged-in user or null
 */
function current_user() {
    if (!isset($_SESSION['user_id'])) return null;

    static $user = null;
    if ($user !== null && $user['id'] == $_SESSION['user_id']) return $user;

    $db = get_db();
    $stmt = $db->prepare("SELECT id, email, role, first_name, last_name, phone, avatar, status FROM users WHERE id = ? AND status = 'active'");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        session_destroy();
        return null;
    }

    return $user;
}

/**
 * Get cleaner record for current user
 */
function current_cleaner() {
    $user = current_user();
    if (!$user || $user['role'] !== 'cleaner') return null;

    static $cleaner = null;
    if ($cleaner !== null) return $cleaner;

    $db = get_db();
    $stmt = $db->prepare("SELECT * FROM cleaners WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    $cleaner = $stmt->fetch();

    return $cleaner;
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    return current_user() !== null;
}

/**
 * Check if user has specific role
 */
function has_role($role) {
    $user = current_user();
    return $user && $user['role'] === $role;
}

/**
 * Require authentication - redirect to login if not
 */
function require_auth($redirect = '/login') {
    if (!is_logged_in()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: $redirect");
        exit;
    }
}

/**
 * Require specific role
 */
function require_role($role, $redirect = '/login') {
    require_auth($redirect);
    if (!has_role($role)) {
        header("Location: /");
        exit;
    }
}

/**
 * Login user
 */
function login_user($email, $password) {
    $db = get_db();
    $stmt = $db->prepare("SELECT id, email, password, role, status FROM users WHERE email = ?");
    $stmt->execute([strtolower(trim($email))]);
    $user = $stmt->fetch();

    if (!$user) return ['success' => false, 'error' => 'Invalid email or password.'];
    if ($user['status'] !== 'active') return ['success' => false, 'error' => 'Your account has been suspended.'];
    if (!password_verify($password, $user['password'])) return ['success' => false, 'error' => 'Invalid email or password.'];

    // Update last login
    $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role'];

    // Determine redirect (validate it's a safe local path)
    $redirect = $_SESSION['redirect_after_login'] ?? null;
    unset($_SESSION['redirect_after_login']);
    if ($redirect && (!str_starts_with($redirect, '/') || str_starts_with($redirect, '//'))) {
        $redirect = null;
    }

    if (!$redirect) {
        switch ($user['role']) {
            case 'admin': $redirect = '/admin'; break;
            case 'cleaner': $redirect = '/dashboard'; break;
            default: $redirect = '/';
        }
    }

    return ['success' => true, 'redirect' => $redirect, 'role' => $user['role']];
}

/**
 * Logout user
 */
function logout_user() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p["path"], $p["domain"], $p["secure"], $p["httponly"]);
    }
    session_destroy();
}

/**
 * Register a new user
 */
function register_user($data) {
    $db = get_db();

    $email = strtolower(trim($data['email']));

    // Check if email exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) return ['success' => false, 'error' => 'An account with this email already exists.'];

    $hash = password_hash($data['password'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32));

    $stmt = $db->prepare("INSERT INTO users (email, password, role, first_name, last_name, phone, email_token, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $email,
        $hash,
        $data['role'] ?? 'customer',
        $data['first_name'] ?? '',
        $data['last_name'] ?? '',
        $data['phone'] ?? '',
        $token
    ]);

    $user_id = $db->lastInsertId();

    return ['success' => true, 'user_id' => $user_id, 'email_token' => $token];
}

/**
 * Generate CSRF token
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output CSRF hidden input
 */
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Verify CSRF token
 */
function verify_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
