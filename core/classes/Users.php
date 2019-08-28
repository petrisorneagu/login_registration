<?php
class Users{
    protected $db;

    public function __construct(){
        $this->db = Database::instance();
    }

    public function get($table, $fields = array()){
        $columns = implode(', ', array_keys($fields));
        //sql query
        $sql = "SELECT * FROM `{$table}` WHERE `{$columns}` = :{$columns}";
        //check if sql query is set
        if($stmt = $this->db->prepare($sql)){
            foreach ($fields as $key => $value) {
                //bind columns
                $stmt->bindValue(":{$key}", $value);
            }
            //execute the query
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    public function update($table, $fields, $condition){
        $columns = '';
        $where = " WHERE ";
        $i = 1; //count the fields to update

//        create columns
        foreach ($fields as $columnName => $columnValue) {
            $columns .= "`{$columnName}` = :{$columnName}";
//            if the field has more than 1 column to update -> add a comma
            if($i < $fields){
                $columns .= ", ";
            }
            $i++;
        }
//        create sql
        $sql = "UPDATE {$table} SET {$columns}";
//        add where condition
        foreach($condition as $conditionName => $conditionValue){
            $sql .= "{$where} `{$conditionName}`= :{$conditionName}";
            $where = " AND ";
        }
//        check if sql is prepared
        if($stmt = $this->db->prepare($sql)) {
            foreach ($fields as $key => $value) {
//                bind column to sql
                $stmt->bindValue(":{$key}",$value);
//                bind where conditions to sql query
                foreach($condition as $key2 => $value2){
                    $stmt->bindValue(":{$key2}", $value2);
                }
            }
        }
//        execute query
        $stmt->execute();

//        print_r($sql);
    }


    public function emailExist($email){
        $email = $this->get('users', array('email' => $email));
        return ((!empty($email))) ? $email : false;
    }

    public function usernameExists($username){
        $username = $this->get('users', array('username' => $username));
        return ((!empty($username))) ? $username : false;
    }

    public function hash($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function redirect($location){
        header("Location: " .BASE_URL. $location);
    }

    public function userData($user_id = int){
        return $this->get('users', array('user_id' => $user_id));
    }

    public function logout(){
        $_SESSION = array();
        session_destroy();
        $this->redirect('index.php');
    }

    public function isLoggedIn()
    {
        return (isset($_SESSION['user_id'])) ? true : false;
    }


}
?>