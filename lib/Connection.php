<?php
require_once 'siteConstant.php';
//Class Created
class Connection
{
    private $conn;
    //Constructor class created
    public function __construct()
    {
        try {
             $this->conn = new PDO("mysql:host=localhost;dbname=eCommerce", 'root', 'Govind@1990');
            } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    //Select Method
    public function select($table, $fields = "*", $join = "", $joinParam = '', $where = "", $whereParam = '', $groupbyFieldName = "", $orderFieldName = "", $order = "", $limit = "",$offset="")
    {
        $sql = "SELECT $fields FROM $table";
        if (!empty($join) && !empty($joinParam)) {
            foreach ($joinParam as $tableName => $data) {
                foreach ($data as $field1 => $field2) {
                    $sql .= " $join $tableName ON $table.$field1 = $tableName.$field2";
                }
            }
        }
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
        if (!empty($groupbyFieldName)) {
            $sql .= " GROUP BY $groupbyFieldName";
        }
        if (!empty($order)) {
            $sql .= " ORDER BY $orderFieldName $order";
        }
        if (!empty($limit)) {
            $sql .= " LIMIT $limit";
        }
        if(!empty($offset)){
            $sql .= " OFFSET $offset";
        }
        $stmt = $this->conn->prepare($sql);
        foreach ($whereParam as $key => $value) {
            if ($value['type'] == 'INT') {
                $stmt->bindParam($key, $value['value'], PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $value['value'], PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //Insert Method
    public function insert($table, $data)
    {
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute($data) == true) {
            $emp_Id = $this->conn->lastInsertId();
            return $emp_Id;
        } else {
            return 'error';
        }
    }
    //Update Method
    public function update($table, $data, $where = 'status')
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key=:$key, ";
        }
        $set = rtrim($set, ", ");
        if($where == 'status'){
            $sql = "UPDATE $table SET $set";
        }
        else{
            $sql = "UPDATE $table SET $set WHERE $where";
        }
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    //Delete Method
    public function delete($table, $where, $whereParam, $image='yes')
    {
        if ($image == "no") {
            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $this->conn->prepare($sql);
            foreach ($whereParam as $key => $value) {
                if ($value['type'] == 'INT') {
                    $stmt->bindParam($key, $value['value'], PDO::PARAM_INT);
                } else {
                    $stmt->bindParam($key, $value['value'], PDO::PARAM_STR);
                }
            }
            if($stmt->execute()){
                echo "success";
            }
        } else {
            $selectsql = "SELECT image FROM $table WHERE $where";
            $selectstmt = $this->conn->prepare($selectsql);
            foreach ($whereParam as $key => $value) {
                if ($value['type'] == 'INT') {
                    $selectstmt->bindParam($key, $value['value'], PDO::PARAM_INT);
                } else {
                    $selectstmt->bindParam($key, $value['value'], PDO::PARAM_STR);
                }
            }
            $selectstmt->execute();
            $profile_Pic = ($selectstmt->fetchAll(PDO::FETCH_ASSOC)[0]['image']);
            if ($table == 'Customers') {
                $imgpath = 'eCommerce/assets/image/customerUpload/' . $value['value'] . '/' . $profile_Pic;
                $dirpath = 'eCommerce/assets/image/customerUpload/' . $value['value'];
            } else {
                $imgpath = 'eCommerce/assets/image/productUpload/' . $value['value'] . '/' . $profile_Pic;
                $dirpath = 'eCommerce/assets/image/productUpload/' . $value['value'];
            }
            $sql = "DELETE FROM $table WHERE $where";
            $stmt = $this->conn->prepare($sql);
            foreach ($whereParam as $key => $value) {
                if ($value['type'] == 'INT') {
                    $stmt->bindParam($key, $value['value'], PDO::PARAM_INT);
                } else {
                    $stmt->bindParam($key, $value['value'], PDO::PARAM_STR);
                }
            }
            if ($stmt->execute()) {
                if (unlink($imgpath)) {
                    if (rmdir($dirpath)) {
                        echo "Data Deleted!!";
                    } else {
                        echo "Folder is not deleted!!";
                    }
                } else {
                        echo "Image is not deleted!!";
                       }
            }
             else {
                echo "Data is not Deleted!!";
            }
        }
    }
}
