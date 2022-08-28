<?php
namespace YaGame\Models;
use YaGame\Interfaces\IPerson;

class Person implements IPerson
{
     private $health;
     private $attack;
     private $protect;
     private $increase;
     private $name;

     public function __construct( $name, $attack, $health, $protect, $increase )
     {
        $this->name = $name;
        $this->attack = $attack;
        $this->health = $health;
        $this->protect = $protect;
        $this->increase = $increase;
     }

     public function getName()
     {
        return $this->name;
     }

     public function setHealth( $health )
     {
        $this->health = $health;
     }

     public function getHealth()
     {
        return $this->health;
     }

     public function setAttack( $attack )
     {
        $this->attack = $attack;
     }

     public function getAttack()
     {
        return $this->attack;
     }

     public function setProtect( $protect )
     {
        $this->protect = $protect;
     }

     public function getProtect()
     {
        return $this->protect;
     }

     public function setIncrease( $increase )
     {
        $this->increase = $increase;
     }

     public function getIncrease()
     {
        return $this->increase;
     }

     public function receiveDamage( $damage )
     {
        $this->health = $this->health - $damge;
     }

     public function isDead() : bool
     {
        return ( $this->health <= 0 );
     }
}
?>
