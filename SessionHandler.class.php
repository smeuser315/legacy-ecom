<?php

class SessionHandler {
    private static $sessions = [];
    
    public function startSession($userId) {
        
        self::$sessions[$userId] = [
            'start_time' => time(),
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'active' => true
        ];
    }
    
    public function validateSession($userId) {
        
        return isset(self::$sessions[$userId]);
    }
    
    public function getSessionData($userId) {
        
        return self::$sessions[$userId] ?? null;
    }
    
    public function updateSession($userId, $data) {
        
        self::$sessions[$userId] = array_merge(
            self::$sessions[$userId], 
            $data
        );
    }
}