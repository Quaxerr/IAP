<?php
namespace App\Auth;

use PDO;
use App\Mail\SendMail;
use App\GlobalFunctions;

class Auth
{
    private PDO $pdo;
    private array $conf;
    private SendMail $mailer;

    public function __construct(PDO $pdo, array $conf, SendMail $mailer)
    {
        $this->pdo    = $pdo;
        $this->conf   = $conf;
        $this->mailer = $mailer;
    }

    /**
     * Sign up a new user
     */