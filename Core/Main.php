<?php
namespace YaGame;

use YaGame\DataBase;
use YaGame\Controllers\PersonTable;
use YaGame\Controllers\SessionTable;

final class Main
{
    public function __construct()
    {
      session_start();

      if ( !isset( $_SESSION['session_key'] ) )

      $_SESSION['session_key'] = session_id();
      $database = new DataBase();
      $session = new SessionTable( $database, $_SESSION['session_key'] );
      $hero = new PersonTable( $database, $session->model->getKey(), 'hero' );
      $goblin = new PersonTable( $database, $session->model->getKey(), 'goblin' );

      $arguments = [
          'session_key' => $session->model->getKey(),
          'goblin_attack'=> $goblin->model->getAttack(),
          'goblin_health'=> $goblin->model->getHealth(),
          'goblin_protect'=> $goblin->model->getProtect(),
          'goblin_increase'=> $goblin->model->getIncrease(),
          'hero_attack'=> $hero->model->getAttack(),
          'hero_health'=> $hero->model->getHealth(),
          'hero_protect'=> $hero->model->getProtect(),
          'hero_increase'=> $hero->model->getIncrease(),
          'battle_log' => $session->model->getBattleLog()
      ];

      $argumentString = '?';

      foreach ( $arguments as $key => $value )
          $argumentString .= $key . '=' . $value . '&';

      $argumentString = substr( $argumentString, 0, -1 );

      if ( $hero->model->isDead() )
      {
          $log .= line( 'battle_lose' );
          header( 'Location: ' . YANDEX_LOSE_URL . $argumentString );
      }

      if ( $goblin->model->isDead() )
      {
          $log .= line( 'battle_win' );
          header( 'Location: ' . YANDEX_WIN_URL . $argumentString );
      }

      if( isset( $_GET['action'] ) )
      {
          if( $_GET['action'] === 'author' )
          {
              header( 'Location: ' . AUTHOR_URL );
              exit;
          }
      }

      if( isset( $_GET['action'] ) )
      {
          if( $_GET['action'] === 'delete' )
          {
              $hero->delete();
              $goblin->delete();
              $session->delete();
              session_destroy();
              header( 'Location: ' . YANDEX_START_URL . $argumentString );
              exit;
          }
      }

      header( 'Location: ' . YANDEX_FORM_URL . $argumentString );
      exit;
    }
}
?>
