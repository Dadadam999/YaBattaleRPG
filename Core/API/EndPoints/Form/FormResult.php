<?php
namespace YaGame\API\EndPoints\Form;

use YaGame\DataBase;
use YaGame\EnemyAi;
use YaGame\Controllers\PersonTable;
use YaGame\Controllers\SessionTable;

final class FormResult
{
    public function __construct()
    {
       header('Content-Type: application/json');
       $input = file_get_contents("php://input");
       $args = json_decode($input)->params;

       if ( empty( $args->session_key ) )
            return '';

       $database = new DataBase();
       $session = new SessionTable( $database, $args->session_key );
       $hero = new PersonTable($database, $session->model->getKey(), 'hero');
       $goblin = new PersonTable($database, $session->model->getKey(), 'goblin');

       $log = '';

       switch (PERSON_ACTIONS[$args->player_choices])
       {
          case 'attack':
              $goblin->model->setHealth( $goblin->model->getHealth() - $hero->model->getAttack() + $goblin->model->getProtect() );
              $log .= line( 'attack', [ '@person_name' => PERSON_NAMES[$hero->model->getName()], '@value' => $hero->model->getAttack() ] );
          break;

          case 'protect':
              $hero->model->setProtect( $hero->model->getProtect() + PROTECT_INCREASE );
              $log .= line( 'protect', [ '@person_name' => PERSON_NAMES[$hero->model->getName()], '@value' => $hero->model->getProtect() ] );
          break;

          case 'heal':
              $hero->model->setHealth( $hero->model->getHealth() + $hero->model->getProtect() );
              $log .= line( 'heal', [ '@person_name' => PERSON_NAMES[$hero->model->getName()], '@value' => $hero->model->getProtect() ] );
          break;

          case 'increase_attack':
              $hero->model->setAttack( $hero->model->getAttack() + $hero->model->getIncrease() );
              $log .= line( 'increase_attack', [ '@person_name' => PERSON_NAMES[$hero->model->getName()], '@value' => $hero->model->getIncrease() ] );
          break;

          default:
              $log .= line( 'miss_step', [ '@person_name' => PERSON_NAMES[$hero->model->getName()] ] );
          break;
       }

       $ai = new EnemyAi( $goblin->model, $hero->model, $args->player_choices );
       $log .= $ai->calculateStep();
       $hero->save();
       $goblin->save();
       $session->model->setBattleLog( $session->model->getBattleLog() . $log  );
       $session->save();

       //$myfile = fopen("log.html", "a") or die("Unable to open file!");
       //fwrite($myfile, '<pre>' . $ai.calculateStep() . '</pre><br><pre>Test: <span>' . $args->session_key . '</span><br><span>' . PERSON_ACTIONS[$args->player_choices] . '</span><span>' . $args->player_choices . '</span><br><span>' . $log . '</span></pre><br>');
       //fclose($myfile);
    }
}
?>
