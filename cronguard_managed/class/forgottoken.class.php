<?php
class ForgotToken {
    public $email;
    public function __construct($email){
        $this->email = $email;
    }

    public function get_email(){
        return $this->email;
    }

    public function check_email(){
        require ("inc/db.inc.php");
        $sql = "select * from token_mail where email = '$this->email'";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
	    return true;
	}else{
            return false;
	}

    }

    public function return_token(){
        require ("inc/db.inc.php");
        $sql = "select * from token_mail where email = '$this->email'";
        $result = $conn->query($sql);
	$row = $result->fetch_assoc();
	return $row['token'];
    }
}
