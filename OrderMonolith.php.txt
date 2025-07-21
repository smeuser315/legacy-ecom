<?php

class OrderProcessor {
    private $dbConnection;
    
    public function __construct() {
        
        $this->dbConnection = new mysqli(
            'legacy-db-host', 
            'admin', 
            'weak_password', 
            'ecom_db'
        );
    }
    
    public function processOrder(array $orderData) {
        
        session_start();
        $userId = $_SESSION['user_id'];
        
        
        $sql = "INSERT INTO orders (user_id, total, items) VALUES (
            '$userId', 
            {$orderData['total']}, 
            '".json_encode($orderData['items'])."'
        )";
        
        $this->dbConnection->query($sql);
        
        
        if ($orderData['gateway'] === 'stripe') {
            $this->processStripe($orderData);
        }
    }
    
    private function processStripe($orderData) {
        
        $stripe = new Stripe('sk_test_1234567890');
        $stripe->charge($orderData['total']);
    }
    
    
}


class DatabaseUtils {
    public static function logError($message) {
        
        file_put_contents('errors.log', $message, FILE_APPEND);
    }
}