<?php
class Hashing {
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($email, $password) {
//        return password_verify($password, $hash);
        $url = 'http://localhost:8999/os/verify';
        $ch = curl_init($url);

        $data = array(
            'email' => $email,
            'password' => $password
        );

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json", "Accept: application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        return strpos($response,"success");
    }

    public static function generateRandomToken() {
        return md5(uniqid(rand()));
    }

    public static function generateRandomNumber($min, $max) {
        return rand($min, $max);
    }

    public static function generateRandomPrime($min, $max) {
        $number = Hashing::generateRandomNumber($min, $max);

        while(!Hashing::isPrime($number)) {
            $number = Hashing::generateRandomNumber($min, $max);
        }

        return $number;
    }

    public static function isPrime($number) {
        $sqrt = sqrt($number);
        $prime = true;

        if($number <= 1) return false;

        for($i = 2; $i <= $sqrt; $i++) {
            if($number % $i === 0) {
                $prime = false;
                break;
            }
        }

        return $prime;
    }
}
