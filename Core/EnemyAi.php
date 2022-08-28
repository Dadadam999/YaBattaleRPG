<?php
namespace YaGame;
use YaGame\Interfaces\IPerson;
use YaGame\Models\Person;

class EnemyAi
{
    private $enemy;
    private $player;
    private $playerChoice;

    public function __construct( IPerson $enemy, IPerson $player, $playerChoice )
    {
        $this->enemy = $enemy;
        $this->player = $player;
        $this->playerChoice = $playerChoice;
    }

    public function calculateStep() : string
    {
        if ( $this->enemy->getHealth() <= $this->player->getAttack() )
            return $this->actionHeal();

        if ( $this->enemy->getAttack() <= $this->player->getProtect() )
            return $this->actionIncreaseAttack();

        if ( $this->enemy->getProtect() <= $this->player->getProtect() )
            return $this->actionProtect();

        if ( empty( rand(0, 2) ) && $this->enemy->getAttack() <= $this->player->getAttack() )
            return $this->actionIncreaseAttack();

        if ( empty( rand(0, 6) ) && PERSON_ACTIONS[$playerChoice] === 'heal')
            return $this->actionProtect();

        if ( empty( rand(0, 8) ) && PERSON_ACTIONS[$playerChoice] === 'heal')
            return $this->actionheal();

        if ( empty( rand(0, 8) ) && PERSON_ACTIONS[$playerChoice] === 'increase_attack')
            return $this->actionIncreaseAttack();

        if ( empty( rand(0, 6) ) && PERSON_ACTIONS[$playerChoice] === 'increase_attack')
            return $this->actionheal();

        if ( empty( rand(0, 3) ) )
            return $this->actionProtect();

        if ( empty( rand(0, 3) ) )
            return $this->actionIncreaseAttack();

        if ( empty( rand(0, 3) ) )
            return $this->actionHeal();

        return $this->actionAttack();
    }

    private function actionAttack() : string
    {
      $this->player->setHealth( $this->player->getHealth() - $this->enemy->getAttack() + $this->player->getProtect() );
      return line( 'attack', [ '@person_name' => PERSON_NAMES[$this->enemy->getName()], '@value' => $this->enemy->getAttack() ] );
    }

    private function actionProtect() : string
    {
      $this->enemy->setProtect( $this->enemy->getProtect() + PROTECT_INCREASE );
      return line( 'protect', [ '@person_name' => PERSON_NAMES[$this->enemy->getName()], '@value' => $this->enemy->getProtect() ] );
    }

    private function actionHeal() : string
    {
      $this->enemy->setHealth( $this->enemy->getHealth() + $this->enemy->getProtect() );
      return line( 'heal', [ '@person_name' => PERSON_NAMES[$this->enemy->getName()], '@value' => $this->enemy->getProtect() ] );
    }

    private function actionIncreaseAttack() : string
    {
      $this->enemy->setAttack( $this->enemy->getAttack() + $this->enemy->getIncrease() );
      return line( 'increase_attack', [ '@person_name' => PERSON_NAMES[$this->enemy->getName()], '@value' => $this->enemy->getIncrease() ] );
    }

    private function actionMissStep() : string
    {
      return line( 'miss_step', [ '@person_name' => PERSON_NAMES[ $this->enemy->getName() ] ] );
    }
}
?>
