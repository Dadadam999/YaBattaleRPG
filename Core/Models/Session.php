<?php
namespace YaGame\Models;

class Session
{
     private $sessionKey;
     private $battleLog;
     private $dateCreate;

     public function __construct( $sessionKey, $dateCreate, $battleLog )
     {
        $this->sessionKey = $sessionKey;
        $this->battleLog = $battleLog;
        $this->dateCreate = $dateCreate;
     }

     public function getKey()
     {
        return $this->sessionKey;
     }

     public function getDateCreate()
     {
        return $this->dateCreate;
     }

     public function getBattleLog()
     {
        return $this->battleLog;
     }

     public function setBattleLog( $battleLog )
     {
        $this->battleLog = $battleLog;
     }
}
?>
