<?php

class Admin extends Controller
{
    function default(){
        
        $this->view("usermanager");
      
    }

    function deleteUser() {
        if (isset($_POST['xoa'])) {
            $id = $_POST['xoa'];
        require_once("./model/usermodel.php");
        $admin = new usermodel();
        $success = $admin->deleteUser($id);
        if ($success == true) {
            $msg = "Xóa liệu thành công";
            $this->view("usermanager", [
                "data" => $success,
                "msg" => $msg,
            ]);
            die;
        } else {
            $this->view("usermanager", [
                "err" => "SQL bị lỗi hàm getDetails",
            ]);
        }

        } else {
            $this->view("usermanager", [ "msg" => "Bị lỗi SQL hàm getDetails"]);
        }
        
    }

    function signupAdmin()
    {
        if (isset($_POST['signup'])) {
            $userName = "";
            $firstName = "";
            $lastName = "";
            $email = "";
            $phone = "";
            $password = "";
            $passwordConfirm = "";
            $vai_tro = "";
            $img_profile = "";
            $address = "";
            $msg = "";
            $success = false;
            if (isset($_POST['userName'])) {
                $userName = $_POST['userName'];
                //$msg .= "1";
            }
            if (isset($_POST['passwordConfirm'])) {
                $passwordConfirm = $_POST['passwordConfirm'];
                //$msg .= "1";
            }
            if (isset($_POST['firstName'])) {
                $firstName = $_POST['firstName'];
                //$msg .= "2";
            }
            if (isset($_POST['lastName'])) {
                $lastName = $_POST['lastName'];
            }

            if (isset($_POST['password'])) {
                $password = $_POST['password'];
                //$msg .= "3";
            }
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
                //$msg .= "4";
            }
            if (isset($_POST['phone'])) {
                $phone = $_POST['phone'];
                //$msg .= "5";
            }

            if (isset($_POST['address'])) {
                $address = $_POST['address'];
                //$msg .= "7";
            }

            if (isset($_POST['vai_tro'])) {
                $vai_tro = $_POST['vai_tro'];
                //$msg .= "7";
            }


            if ($userName == "" || $vai_tro == "" || $password == "" || $firstName == "" || $lastName == "" || $address == "" || $email == "" || $phone == "" || $passwordConfirm == "" || $address == "") {
                $msg = "Please fill all require fields!";
            }
            if ($password != $passwordConfirm) {
                $msg = "Mật khẩu không giống nhau";
            } else {
                // print_r($_FILES);
                $img_profile = $this->upload_file_user($userName, $_FILES);

                $password = password_hash($password, PASSWORD_DEFAULT);


                // $signup = $this->model("usermodel"); //usermodel la ten file usermodel.php

                require_once("./model/usermodel.php");
                $signup = new usermodel();
                // $signup->insertUser()

                $success = $signup->insertUser($userName, $firstName, $lastName, $email, $phone, $password, $vai_tro, $img_profile, $address);

                if ($success == true) {
                    $msg = "Thêm thành công tài khoản";
                    // $show = "<script>

                    //             </script>";

                    $this->view("usermanager", [
                        // "show" => $show,
                        "msg" => $msg,
                    ]);
                    die;
                }
                $this->view("usermanager", [

                    "err" => "Tài khoản đã tồn tại",
                ]);
            }
            $this->view("usermanager", [

                "msg" => $msg,
            ]);
        } else {
            // echo "Dang o day 1";
            $this->view("usermanager", []);
        }
    }



    function getAllUser()
    {
        if ($_SESSION['vai_tro']) {
            require_once("./model/usermodel.php");
            $admin = new usermodel();
            $success = $admin->getAllUser();
            // print_r($success);
            if ($success == true) {
                $msg = "Lấy dữ liệu thành công";
                $this->view("usermanager", [
                    "data" => $success,
                    "msg" => $msg,
                ]);
                die;
            } else {
                $this->view("usermanager", [
                    "err" => "SQL bị lỗi",
                ]);
            }
        } else {
            $this->view("usermanager", [
                "err" => "Không đủ quyền - Vui lòng liên hệ admin",
            ]);
        }
    }

    function updateAdminUser() {
        require_once("./model/usermodel.php");
        $user = new usermodel();
        // echo "Dang chay updateAdminUser";
        if (isset($_POST['update'])) {
            
            $userName = "";
            $firstName = "";
            $lastName = "";
            $email = "";
            $phone = "";
            $password = "";
            $vai_tro = "0";
            $img_profile = "";
            $address = "";
            
        
            if (isset($_POST['ten_dang_nhap'])) {
                $userName = $_POST['ten_dang_nhap'];
                //$msg .= "1";
            }
           
            if (isset($_POST['ten'])) {
                $firstName = $_POST['ten'];
                //$msg .= "2";
            }
            if (isset($_POST['ho'])) {
                $lastName = $_POST['ho'];
            }

            if (isset($_POST['email'])) {
                $email = $_POST['email'];
                //$msg .= "4";
            }
            if (isset($_POST['dien_thoai'])) {
                $phone = $_POST['dien_thoai'];
                //$msg .= "5";
            }

            if (isset($_POST['dia_chi'])) {
                $address = $_POST['dia_chi'];
                //$msg .= "6";
            }

            if (isset($_POST['id_user'])) {
                $id = $_POST['id_user'];
                //$msg .= "7";
                echo $userName . "<br>"; 
            }

            if (isset($_POST['vai_tro'])) {
                $vai_tro = $_POST['vai_tro'];
                //$msg .= "7";
            }

            if (isset($_POST['img_profile'])) {
                $img_profile = $_POST['img_profile'];
                //$msg .= "7";
            }
     
            if (isset($_POST['mat_khau'])) {
                $password = $_POST['mat_khau'];
                //$msg .= "7";
            }

            if (false)
                {
                $msg = "Please fill all require fields!";   
            } else {
                    // $password = password_hash($password, PASSWORD_DEFAULT);
                // if ( $_FILES["file"]["error"] == 0){
                    $img_profile = $this->upload_file_user($userName, $_FILES); 
                    // echo $userName . "<br>"; 
                    // echo $firstName. "<br>"; 
                    // echo $lastName. "<br>";   
                    // echo $email. "<br>"; 
                    // echo $phone. "<br>"; 
                    // echo $password. "<br>"; 
                    // echo $vai_tro. "<br>"; 
                    // echo  $img_profile. "<br>";  
                    // echo $address. "<br>"; 
                    // echo  $id. "<br>"; 

                    $success = $user->updateUserAdmin( $userName, $firstName, $lastName, $email, $phone, $password, $vai_tro, $img_profile, $address, $id );
                    
                
               
               
            
    
                if ($success == true) {
                    $msg = "Đã cập nhật thành công!";
      
                    $this->view("usermanager", [
            
                        "msg" => $msg,
                    ]);
                    die;
                } else {
                    $msg = "Không cập nhật thành công";
                    $this->view("usermanager", [
                        "msg" => $msg,
                        "err" => $msg,
                    ]);
                    die;
                }
            }
        } else {
            $this->view("usermanager", [
                'msg'=> "Kiểm tra internet",
            ]);
        }
    }
    




    function getDetailAndEdit(){
        if (isset($_POST['sua'])) {
            $id = $_POST['sua'];
            // print($id);
            require_once("./model/usermodel.php");
            $admin = new usermodel();
            $success = $admin->getUser($id);
            if ($success == true) {
                $msg = "Lấy dữ liệu thành công";
                $this->view("editUserDetails", [
                    "data" => $success,
                    "msg" => $msg,
                ]);
                die;
            } else {
                $this->view("editUserDetails", [
                    "err" => "SQL bị lỗi hàm getDetails",
                ]);
            }


        } else {
        $this->view("editUserDetails", [ "msg" => "Bị lỗi SQL hàm getDetails"]);
        }
        
    }


    function getDetail()
    {
        if (isset($_POST['xem'])) {
            $id = $_POST['xem'];
            // print($id);
            require_once("./model/usermodel.php");
            $admin = new usermodel();
            $success = $admin->getUser($id);
            if ($success == true) {
                $msg = "Lấy dữ liệu thành công";
                $this->view("userDetails", [
                    "data" => $success,
                    "msg" => $msg,
                ]);
                die;
            } else {
                $this->view("userDetails", [
                    "err" => "SQL bị lỗi hàm getDetails",
                ]);
            }


        } else {
        $this->view("userDetails", [ "msg" => "Bị lỗi SQL hàm getDetails"]);
        }
    }
}