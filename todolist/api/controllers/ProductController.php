<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'models/Product.php';
    
    class ProductController {
        public function index() {
            $product_model = new Product();
            echo $product_model->getAll();
        }

        public function create() {
            $product_model = new Product();
            $name = (isset($_POST["name"])) ? $_POST["name"] : '';
            $description = (isset($_POST["description"])) ? $_POST["description"] : '';
            $price = (isset($_POST["price"])) ? $_POST["price"] : '';
            if(!empty($name) && !empty($description) && !empty($price)) {
                $product_model->name = $name;
                $product_model->description = $description;
                $product_model->price = $price;
                if($product_model->insert()){
                    // http_response_code(201);
                    echo json_encode(array("error" => false,
                                            "message" => "Product was created."));
                    // echo json_encode($product_model->result);
                }
                else{
                    // http_response_code(503);
                    echo json_encode(array("error" => true,
                                            "message" => "Unable to create product."));
                }
                // http_response_code(201); 
                // echo $product_model->insert();
            } else {
                // http_response_code(400);
                echo json_encode(array("error" => true,
                                        "message" => "Unable to create product. Data is incomplete."));
            }
        }

        public function update() {
            $product_model = new Product();
            $name = (isset($_POST["name"])) ? $_POST["name"] : '';
            $description = (isset($_POST["description"])) ? $_POST["description"] : '';
            $price = (isset($_POST["price"])) ? $_POST["price"] : '';
            $id = (isset($_POST["id"])) ? $_POST["id"] : '';
            if(!empty($name) && !empty($description) && !empty($price) && !empty($id)) {
                $product_model->name = $name;
                $product_model->description = $description;
                $product_model->price = $price;
                if($product_model->update($id)){
                    // http_response_code(201);
                    echo json_encode(array("error" => false,
                                            "message" => "Product was updated."));
                }
                else{
                    // http_response_code(503);
                    echo json_encode(array("error" => true,
                                            "message" => "Unable to update product."));
                }
            } else {
                // http_response_code(400);
                echo json_encode(array("error" => true,
                                        "message" => "Unable to update product. Data is incomplete."));
            }
        }

        public function delete() {
            if(isset($_POST["id"])) {
                $id = $_POST["id"];
                $product_model = new Product();
                $is_delete = $product_model->delete($id);
                if ($is_delete) {
                    $result['error'] = false;
                    $result['message'] = "Product deleted successfully";
                } else {
                    $result['error'] = true;
                    $result["message"] = "Fail to delete product!";
                }
                echo json_encode($result);
            }
        }
    }
?>