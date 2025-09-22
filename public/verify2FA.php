<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../config/conf.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Layouts\Layouts;

try {
    $ObjLayout = new Layouts();
    $ObjLayout->header($conf);
    $ObjLayout->navbar($conf);
    $ObjLayout->banner($conf);

    $msg   = '';
    $email = trim($_GET['email'] ?? '');
    $code  = trim($_GET['code'] ?? '');

    if ($email && $code) {
        $stmt = $pdo->prepare("SELECT id, verified, verification_code FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $msg = "<div class='alert alert-danger'>Invalid email address.</div>";
        } elseif ($user['verified']) {
            $msg = "<div class='alert alert-success'>Your account is already verified.</div>";
        } elseif ($user['verification_code'] !== $code) {
            $msg = "<div class='alert alert-danger'>Invalid verification code.</div>";
        } else {
            $stmt = $pdo->prepare("UPDATE users SET verified = 1, verification_code = NULL WHERE id = ?");
            $stmt->execute([$user['id']]);
            $msg = "<div class='alert alert-success'>Account verified successfully! You may now <a href='signin.php'>sign in</a>.</div>";
        }
    } else {
        $msg = "<div class='alert alert-info'>No verification data provided.</div>";
    }

    echo "<div class='container my-5'><h2>Account Verification</h2>{$msg}</div>";

    $ObjLayout->footer($conf);

} catch (\Exception $e) {
    echo "<div class='container my-5'><p style='color:red'>Error: " . htmlspecialchars($e->getMessage()) . "</p></div>";
}