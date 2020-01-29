<?php
class GenerateToken {
    public $email;
    public function __construct($email){
        $this->email = $email;
    }

    public function get_email(){
        return $this->email;
    }

    public function validate_email($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
	} else {
	    return false;
        }

    }

    public function generate_token(){
        return substr(md5(mt_rand()), 0, 6);
    }

    public function write_to_database($token, $email){
	require ("db.inc.php");
	$stmt = $conn->prepare("INSERT INTO token_mail (token, email)
        VALUES (?, ?)");
        $stmt->bind_param("ss", $token, $email);
        if ($stmt->execute() === TRUE){
            return true;
        }
        else {
            return false;
        }
        $stmt->close();
    }
}
