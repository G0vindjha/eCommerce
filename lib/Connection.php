<?php
use PHPMailer\PHPMailer\PHPMailer;
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
    public function orderNotification($notification,$dataArr = 'null'){
        if ($notification == 'order') {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'shopbyproto@gmail.com'; //your email
            $mail->Password = 'jxkkpwdwbyjhegao'; //your Password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = '465';
            $mail->setFrom('shopbyproto@gmail.com'); //your email
            $mail->addAddress($dataArr['useremail']);
            $mail->isHTML(true);
            $mail->Subject = 'Order confirm' . $dataArr["productname"];
            $mail->Body = ' </table><table role="presentation"
                style="width: 100%; border-collapse: collapse; border: 0px; border-spacing: 0px; font-family: Arial, Helvetica, sans-serif; background-color: rgb(239, 239, 239);">
                <tbody>
                  <tr>
                    <td align="center" style="padding: 1rem 2rem; vertical-align: top; width: 100%;">
                      <table role="presentation"
                        style="max-width: 600px; border-collapse: collapse; border: 0px; border-spacing: 0px; text-align: left;">
                        <tbody>
                          <tr>
                            <td style="padding: 40px 0px 0px;">
                              <div style="text-align: left;">
                                <div class="text-center" style="padding-bottom: 20px;"><h3 class="text-center" style="color:#118383">PROTO</h3></div>
                              </div>
                              <div style="padding: 20px; background-color: rgb(255, 255, 255);">
                                <div style="color: rgb(33, 22, 90); text-align: center;">
                                  <h1 style="margin: 1rem 0">Invoice</h1>
                                  <p>Thank you ' . $dataArr["username"] . ' for you order from Proto.</p>
                                  <p>Your ' . $dataArr["productname"] . ' is ariving soon. </p>
                                  <p>Your Delievery address is ' . $dataArr["address"] . ' </p>
                                  <p style="padding-bottom: 16px">You have paid : <strong style="font-size: 130%;background-color:#118383;padding:10px; border-radius:5px;"> Rs.' . $dataArr["orderamount"] . ' </strong></p>
                                  <p style="padding-bottom: 16px">You have ordered ' . $dataArr["quantity"] . ' X ' . $dataArr["productname"] . ' on ' . $dataArr["orderDate"] . ' worth of ' . $dataArr["orderamount"] . ' </p>
                                  <p style="padding-bottom: 16px">Thanks,<br>The Proto team</p>
                                </div>
                              </div>
                              <div style="padding-top: 20px; color: rgb(153, 153, 153); text-align: center;">
                                <p style="padding-bottom: 16px">Thank you for Joining ♥ </p>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
                </table>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
        }
    }
}
