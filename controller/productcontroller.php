<?php
class Product extends Controller
{
    function default()
    {
        // $this->view("product");
        $this->getAllProduct();
    }

    function getAllProduct()
    {
        require_once("./model/productmodel.php");
        $product = new productmodel();
        $success = $product->getAllProduct();
        // print_r($success);
        if ($success == true) {
            $msg = "Lấy dữ liệu thành công";
            $this->view("product", [
                "data" => $success,
                "msg" => $msg,
            ]);
            die;
        } else {
            $this->view("product", [
                "err" => "SQL bị lỗi",
            ]);
        }
    }

    function getProductShow(){
        if (isset($_POST['xem'])) {
            $id = $_POST['xem'];
            // echo $id;

            
            require_once("./model/productmodel.php");
            $admin = new productmodel();
            $success = $admin->getProduct($id);
            // print_r($success);
            if ($success == true) {
        
                $msg = "Lấy dữ liệu thành công";
                $this->view("productDetailsShow", [
                    "data" => $success,
                    "msg" => $msg,
                ]);
                // echo "đang chay trong 2";
                die;
            } else {
                // echo "đang chay trong 1";
                $this->view("productDetailsShow", [
                    "err" => "SQL bị lỗi hàm getDetails",
                ]);
            }
        } else {
            $this->view("productDetailsShow", ["msg" => "Bị lỗi SQL hàm getDetails"]);
        }
    }







    function getAllProductAdmin()
    {
        require_once("./model/productmodel.php");
        $product = new productmodel();
        $success = $product->getAllProduct();
        // print_r($success);

        if ($success == true) {
            $msg = "Lấy dữ liệu thành công";
            $this->view("productmanager", [
                "data" => $success,
                "msg" => $msg,
            ]);
            die;
        } else {
            $this->view("productmanager", [
                "err" => "SQL bị lỗi",
            ]);
        }
    }

    function getAllProductAdminPagination()
    {
        try {
            // require_once ("./core/Database.php");
            // Find out how many items are in the table
        
            $total = $this->conn->query('
                SELECT
                    COUNT(*)
                FROM
                    product
            ')->fetchColumn();
        
            // How many items to list per page
            $limit = 20;
        
            // How many pages will there be
            $pages = ceil($total / $limit);
        
            // What page are we currently on?
            $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default'   => 1,
                    'min_range' => 1,
                ),
            )));
        
            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        
            // Some information to display to the user
            $start = $offset + 1;
            $end = min(($offset + $limit), $total);
        
            // The "back" link
            $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
        
            // The "forward" link
            $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
        
            // Display the paging information
            echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
        
            // Prepare the paged query
            $stmt = $this->conn->prepare('
                SELECT
                    *
                FROM
                    product
                ORDER BY
                    id
                LIMIT
                    :limit
                OFFSET
                    :offset
            ');
        
            // Bind the query params
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
        
            // Do we have any results?
            if ($stmt->rowCount() > 0) {
                // Define how we want to fetch the results
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $iterator = new IteratorIterator($stmt);
        
                // Display the results
                foreach ($iterator as $row) {
                    echo '<p>', $row['name'], '</p>';
                }
        
            } else {
                echo '<p>No results could be displayed.</p>';
            }
        
        } catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
        }
    }

    function addProduct()
    {
        if (isset($_POST['signup'])) {
            $ten_thiet_ke = "";
            $chu_de = "";
            $dien_tich = "";
            $mau = "";
            $cong_nghe = "";
            $gia = "";
            $img_product = "";
            $mo_ta = "";

            $msg = "";
            $success = false;
            if (isset($_POST['ten_thiet_ke'])) {
                $ten_thiet_ke = $_POST['ten_thiet_ke'];
                //$msg .= "1";
            }
            if (isset($_POST['chu_de'])) {
                $chu_de = $_POST['chu_de'];
                //$msg .= "1";
            }
            if (isset($_POST['dien_tich'])) {
                $dien_tich = $_POST['dien_tich'];
                //$msg .= "2";
            }
            if (isset($_POST['mau'])) {
                $mau = $_POST['mau'];
            }

            if (isset($_POST['cong_nghe'])) {
                $cong_nghe = $_POST['cong_nghe'];
                //$msg .= "3";
            }
            if (isset($_POST['gia'])) {
                $gia = $_POST['gia'];
                //$msg .= "4";
            }
            if (isset($_POST['mo_ta'])) {
                $mo_ta = $_POST['mo_ta'];
                //$msg .= "5";
            }



            if ($ten_thiet_ke == "" || $dien_tich == "" || $gia == "") {
                $msg = "Please fill all require fields!";
            } else {
                // print_r($_FILES);
                $img_product = $this->upload_file_product($dien_tich, $_FILES);



                // $signup = $this->model("usermodel"); //usermodel la ten file usermodel.php

                require_once("./model/productmodel.php");
                $product = new productmodel();
                // $signup->insertUser()

                $success = $product->insertProduct(
                    $ten_thiet_ke,
                    $chu_de,
                    $dien_tich,
                    $mau,
                    $cong_nghe,
                    $gia,
                    $img_product,
                    $mo_ta
                );

                if ($success == true) {
                    $msg = "Tạo sản phẩm thành công";
          
                    $this->view("productmanager", [
                        // "show" => $show,
                        "msg" => $msg,
                    ]);
                    die;
                }
                $this->view("productmanager", [

                    "err" => "Sản phẩm đã tạo",
                ]);
            }
            $this->view("productmanager", [

                "msg" => $msg,
            ]);
        } else {
            // echo "Dang o day 1";
            $this->view("productmanager", [

                "err" => "Không có đầu vào"
            ]);
        }
    }

    function getDetail()
    {
        if (isset($_POST['xem'])) {
            $id = $_POST['xem'];
            // print($id);
            require_once("./model/productmodel.php");
            $admin = new productmodel();
            $success = $admin->getProduct($id);
            if ($success == true) {
                $msg = "Lấy dữ liệu thành công";
                $this->view("productDetails", [
                    "data" => $success,
                    "msg" => $msg,
                ]);
                die;
            } else {
                $this->view("productDetails", [
                    "err" => "SQL bị lỗi hàm getDetails",
                ]);
            }
        } else {
            $this->view("productDetails", ["msg" => "Bị lỗi SQL hàm getDetails"]);
        }
    }


    function getDetailAndEdit()
    {
        if (isset($_POST['sua'])) {
            $id = $_POST['sua'];
            // print($id);
            require_once("./model/productmodel.php");
            $admin = new productmodel();
            $success = $admin->getProduct($id);
            if ($success == true) {
                $msg = "Lấy dữ liệu thành công";
                $this->view("editProductDetails", [
                    "data" => $success,
                    "msg" => $msg,
                ]);
                die;
            } else {
                $this->view("editProductDetails", [
                    "err" => "SQL bị lỗi hàm getDetails",
                ]);
            }
        } else {
            $this->view("editProductDetails", ["msg" => "Bị lỗi SQL hàm getDetails"]);
        }
    }

    function updateProduct()
    {
       
        if (isset($_POST['update'])) {
            
            $ten_thiet_ke = "";
            $chu_de = "";
            $dien_tich = "";
            $mau = "";
            $cong_nghe = "";
            $gia = "";
            $img_product = "";
            $mo_ta = "";
            $id  = "";
            $msg = "";
            $success = false;
            if (isset($_POST['id'])) {
                $id = $_POST['id'];
                //$msg .= "1";
            }
            if (isset($_POST['ten_thiet_ke'])) {
                $ten_thiet_ke = $_POST['ten_thiet_ke'];
                //$msg .= "1";
            }
            if (isset($_POST['chu_de'])) {
                $chu_de = $_POST['chu_de'];
                //$msg .= "1";
            }
            if (isset($_POST['dien_tich'])) {
                $dien_tich = $_POST['dien_tich'];
                //$msg .= "2";
            }
            if (isset($_POST['mau'])) {
                $mau = $_POST['mau'];
            }

            if (isset($_POST['cong_nghe'])) {
                $cong_nghe = $_POST['cong_nghe'];
                //$msg .= "3";
            }
            if (isset($_POST['gia'])) {
                $gia = $_POST['gia'];
                //$msg .= "4";
            }
            if (isset($_POST['mo_ta'])) {
                $mo_ta = $_POST['mo_ta'];
                //$msg .= "5";
            }


            
            if (false)
                {
                $msg = "Please fill all require fields!";  
            } else {

                echo "dang chay trong 1";
                // $password = password_hash($password, PASSWORD_DEFAULT);
                // if ( $_FILES["file"]["error"] == 0){
                $img_product = $this->upload_file_product($dien_tich, $_FILES);

                require_once("./model/productmodel.php");
                $admin = new productmodel();
                $success = $admin->updateProduct(
                    $ten_thiet_ke,
                    $chu_de,
                    $dien_tich,
                    $mau,
                    $cong_nghe,
                    $gia,
                    $img_product,
                    $mo_ta,
                    $id
                );
                if ($success == true) {
                    $msg = "Đã cập nhật thành công!";

                    $this->view("productmanager", [

                        "msg" => $msg,
                    ]);
                    die;
                } else {
                    $msg = "Không cập nhật thành công";
                    $this->view("productmanager", [
                        "msg" => $msg,
                        "err" => $msg,
                    ]);
                    die;
                }
            } 



        } else {
            $this->view("productmanager", [
                'msg' => "Kiểm tra internet",
            ]);
        }
    }


    function deleteProduct() {
        if (isset($_POST['xoa'])) {
            $id = $_POST['xoa'];
        require_once("./model/productmodel.php");
        $admin = new productmodel();
        $success = $admin->deleteProduct($id);
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

}
