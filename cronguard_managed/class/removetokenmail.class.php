<?php
class RemoveTokenMail {
    public $token;
    public function __construct($token){
        $this->token = $token;
    }

    public function get_token(){
        return $this->token;
    }

    public function check_token(){
        require_once ("db.inc.php");
        $sql = "select * from token_mail where token = '$this->token'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            return true;
        }else{
            return false;
        }

    }
    
    public function remove_from_database($token){
	require ("db.inc.php");
	$stmt = $conn->prepare("DELETE FROM token_mail WHERE token = ?");
        $stmt->bind_param("s", $token);
        if ($stmt->execute() === TRUE){
            return true;
        }
        else {
            return false;
        }
        $stmt->close();
    }
}
