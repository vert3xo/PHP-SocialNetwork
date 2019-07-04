<?php
class Login {
    public static function isLoggedIn() {
        if (isset($_COOKIE['SESSION'])) {
            if (DB::query("SELECT user_id FROM login_tokens WHERE token=:token", array("token"=>hash("sha256", $_COOKIE['SESSION'])))) {
                if (isset($_COOKIE['SESSION_'])) {
                    $userid = DB::query("SELECT user_id FROM login_tokens WHERE token=:token", array("token"=>hash("sha256", $_COOKIE['SESSION'])))[0][0];
                    return $userid;
                } else {
                    $cstrong = true;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    $userid = DB::query("SELECT user_id FROM login_tokens WHERE token=:token", array("token"=>hash("sha256", $_COOKIE['SESSION'])))[0][0];
                    DB::query("INSERT INTO login_tokens(token, user_id) VALUES(:token, :user_id)", array("token"=>hash('sha256', $token), "user_id"=>$userid));
                    DB::query("DELETE FROM login_tokens WHERE token=:token", array("token"=>hash("sha256", $_COOKIE['SESSION'])));
                    setcookie("SESSION", $token, time() + 60 * 60 * 5, '/', null, null, true);
                    setcookie("SESSION_", '1', time() + 60 * 60 * 4, '/', null, null, true);
                    
                    return $userid;
                }
            }
        }

        return false;
    }
}