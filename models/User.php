<?php

class User {
    public function login($mail, $password) {

    }

    public function register($mail, $username,$password, $confirmPassword) {
        if ($password !== $confirmPassword) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = DB::getInstance()->prepare("INSERT INTO users (mail, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $mail, $username, $hashedPassword);
        return $stmt->execute();

    }
}