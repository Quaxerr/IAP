<?php
namespace App\Forms;

class Forms
{
    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    // Render Sign Up form
    public function signup(): void
    {
        ?>
        <div class="container my-5">
            <h2>Sign Up</h2>
            <form method="POST" action="" class="mt-3">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" name="name" id="fullname" class="form-control" placeholder="Enter your fullname" required>
                </div>