<?php
namespace YaGame\Interfaces;

interface IPerson
{
    public function __construct( $name, $attack, $health, $protect, $increase );
    public function getName();
    public function setHealth( $health );
    public function getHealth();
    public function setAttack( $attack );
    public function getAttack();
    public function setProtect( $protect );
    public function getProtect();
    public function setIncrease( $increase );
    public function getIncrease();
    public function receiveDamage( $damage );
    public function isDead() : bool;
}
?>
