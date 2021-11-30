<?php 
    class Controller
    {
        function model($model) {
            require_once "./model/" . $model . ".php";
            return new $model;
        }

        function view( $view, $data = []) {
            require_once "./view/" . $view . ".php";
        }
       

        function upload_file_user($ten_dang_nhap, $file) {
            if (isset($file["file"])) {
                $allowedExts = array("jpg", "jpeg", "gif", "png");
                $nameParts = explode(".", $file["file"]["name"]);
                $extension = end($nameParts);
                if ((($file["file"]["type"] == "image/gif")
                        || ($file["file"]["type"] == "image/jpeg")
                        || ($file["file"]["type"] == "image/png")
                        || ($file["file"]["type"] == "image/pjpeg"))
                    && ($file["file"]["size"] < 5000000)
                    && in_array($extension, $allowedExts)
                ) {
                    if ($file["file"]["error"] == 0) {
                       if (!file_exists("public/upload/user/$ten_dang_nhap"))
                            mkdir("public/upload/user/" . $ten_dang_nhap , 0777, 1);
                        if (file_exists("public/upload/user/" . $ten_dang_nhap . $file["file"]["name"])) {
                            unlink("public/upload/user/" . $ten_dang_nhap . $file["file"]["name"]);
                        }

                        move_uploaded_file($file["file"]["tmp_name"], "public/upload/user/" . $ten_dang_nhap . "/" . $file["file"]["name"]);
                        $img_profile = "/mvc/public/upload/user/" . $ten_dang_nhap . "/" . $file["file"]["name"];
                    }
                   
                } else {
                    $img_profile = "";
                }
            return $img_profile;
            }
        }

        function upload_file_product($ten_dang_nhap, $file) {
            if (isset($file["file"])) {
                $allowedExts = array("jpg", "jpeg", "gif", "png");
                $nameParts = explode(".", $file["file"]["name"]);
                $extension = end($nameParts);
                if ((($file["file"]["type"] == "image/gif")
                        || ($file["file"]["type"] == "image/jpeg")
                        || ($file["file"]["type"] == "image/png")
                        || ($file["file"]["type"] == "image/pjpeg"))
                    && ($file["file"]["size"] < 5000000)
                    && in_array($extension, $allowedExts)
                ) {
                    if ($file["file"]["error"] == 0) {
                       if (!file_exists("public/upload/product/$ten_dang_nhap"))
                            mkdir("public/upload/product/" . $ten_dang_nhap , 777 , 1);
                        if (file_exists("public/upload/product/" . $ten_dang_nhap . $file["file"]["name"])) {
                            unlink("public/upload/product/" . $ten_dang_nhap . $file["file"]["name"]);
                        }

                        move_uploaded_file($file["file"]["tmp_name"], "public/upload/product/" . $ten_dang_nhap . "/" . $file["file"]["name"]);
                        $img_profile = "/mvc/public/upload/product/" . $ten_dang_nhap . "/" . $file["file"]["name"];
                    }
                   
                } else {
                    $img_profile = "";
                }
            return $img_profile;
            }
        }

        function upload_file_news($ten_dang_nhap, $file) {
            if (isset($file["file"])) {
                $allowedExts = array("jpg", "jpeg", "gif", "png");
                $nameParts = explode(".", $file["file"]["name"]);
                $extension = end($nameParts);
                if ((($file["file"]["type"] == "image/gif")
                        || ($file["file"]["type"] == "image/jpeg")
                        || ($file["file"]["type"] == "image/png")
                        || ($file["file"]["type"] == "image/pjpeg"))
                    && ($file["file"]["size"] < 5000000)
                    && in_array($extension, $allowedExts)
                ) {
                    if ($file["file"]["error"] == 0) {
                       if (!file_exists("public/upload/news/$ten_dang_nhap"))
                            mkdir("public/upload/news/" . $ten_dang_nhap , 777 , 1);
                        if (file_exists("public/upload/news/" . $ten_dang_nhap . $file["file"]["name"])) {
                            unlink("public/upload/news/" . $ten_dang_nhap . $file["file"]["name"]);
                        }

                        move_uploaded_file($file["file"]["tmp_name"], "public/upload/news/" . $ten_dang_nhap . "/" . $file["file"]["name"]);
                        $img_profile = "/mvc/public/upload/news/" . $ten_dang_nhap . "/" . $file["file"]["name"];
                    }
                   
                } else {
                    $img_profile = "";
                }
            return $img_profile;
            }
        }
    }


?>