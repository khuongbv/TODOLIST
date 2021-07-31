<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");    

    require_once 'models/Model.php';

    class Product extends Model {
        public $id;
        public $name;
        public $description;
        public $price;
        
        public function __construct() {
            parent::__construct();
        }

        public function getAll() {
            $product_arr = array();
            $obj_select = $this->connection
                ->prepare("SELECT * FROM products ORDER BY id DESC");
            $arr_select = [];
            $obj_select->execute($arr_select);
            $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);
            http_response_code(200);
            $result["products"] = $products;
            return json_encode($result["products"]);
        }

        public function insert(){  
            $query = "INSERT INTO products SET
                name=:name, price=:price, description=:description";
            $stmt = $this->connection->prepare($query);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->description=htmlspecialchars(strip_tags($this->description));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":description", $this->description);

            // if($stmt->execute()){
            //     $product = $stmt->fetch(PDO::FETCH_ASSOC);
            //     $result["data"] = $product;
            //     json_encode($result);
            //     return $stmt->execute();
            // } else {
            //     return $stmt->execute();
            // }
            $stmt->execute();
            $result = [
                "products" => [
                    "name" => $this->name,
                    "description" => $this->description,
                    "price" => $this->price
                ]
            ];
            return json_encode($result);
        }

        public function update($id) {
            $query = "UPDATE products SET
                name=:name, price=:price, description=:description WHERE id = :id";
            $stmt = $this->connection->prepare($query);

            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->price=htmlspecialchars(strip_tags($this->price));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->id=htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        }

        public function delete($id) {
            $obj_delete = $this->connection->prepare("DELETE FROM products WHERE id = $id");
            return $obj_delete->execute();
        }
    }
?>