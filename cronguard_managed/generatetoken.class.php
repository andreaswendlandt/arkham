<?php
class GenerateToken {
    public $email;
    public function __construct($email){
        $this->email = $email;
    }

    public function get_email(){
        return $this->email;
    }

    public function validate_email(){
    }

    public function generate_token(){
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
