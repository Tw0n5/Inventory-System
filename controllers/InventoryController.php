<?php
    class InventoryController {

        public function getLoginPage(){
            include 'views/login.php';
        }

        public function getDashboardPage(){
            //collect model instances data variables to automatically extract inside layout files
            //$units = InventoryModel::getAllUnits();
            //$metrics = InventoryModel::getMetrics();
            include 'views/dashboard.php';
        }

        public function loginProcess(){
            //extract incoming JSON payload from standard stream inputs
            $input= json_decode(file_get_contents('php://input'), true);
            $username = $input['username'] ?? '';
            $password = $input['password'] ?? '';
           
          

            header('Content-Type: application/json');
            if (InventoryModel::authenticate($username, password: $password)){
                
                echo json_encode(['success' => true, 'redirectUrl'=> '/dashboard']);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Invalid Credentials']);
            }
        }

        public function getInventoryData(){
            header('Content-Type: application/json');
            echo json_encode([
                'units'=> InventoryModel::getAllUnits(),
                'metrics'=> InventoryModel::getMetrics()
            ]);
        }
    }
?>