<?php 

ini_set(('session.use_only_cookies'), 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params(( [
    'lifetime' => 10, // change later
    'path' => '/',
    'domain' => 'localhost',
    'secure' => true,
    'httponly' => true
]));

session_start();

if (!isset($_SESSION['last_regeneration_time'])) {
    regenerate_session_id();
} else {
    $interval = 60  * 30; // 30 minutes
    if (time() - $_SESSION['last_regeneration_time'] >= $interval) {
        regenerate_session_id();
    }
}

function regenerate_session_id() {
    session_regenerate_id();
    $_SESSION['last_regeneration_time'] = time();
}
