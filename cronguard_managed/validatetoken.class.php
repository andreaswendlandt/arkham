<?php
class ValidateToken {
    public $token;
    public function __construct($token){
        $this->token = $token;
    }

    public function get_token(){
        return $this->token;
    }

    public function check_token(){
        require_once ("db.inc.php");
        $sql = "select * from job_foo where token = '$this->token'";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
	    return true;
	}else{
            return false;
	}

    }
}
