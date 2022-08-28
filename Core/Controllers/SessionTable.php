<?php
namespace YaGame\Controllers;

use YaGame\Interfaces\ITable;
use YaGame\Models\Session;
use YaGame\DataBase;

class SessionTable implements ITable
{
    public $model;
    private $sessionKey;

    private $tableSchema = [
        'name' => DB_PREFIX . 'sessions',
        'columns' => [
              'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
              'dateCreate' => 'datetime',
              'sessionKey' => 'varchar(1024)',
              'battleLog' => 'longtext'
        ]
    ];

    public function __construct( DataBase $database, $sessionKey )
    {
        $this->database = $database;
        $this->sessionKey = $sessionKey;
        $this->checkOrRepairSchema();
        $this->init();
    }

    private function checkOrRepairSchema()
    {
        if ( !$this->database->issetTable( $this->tableSchema['name'] ) )
        {
            $this->database->createTable( $this->tableSchema['name'], $this->tableSchema['columns'] );
        }
        else
        {
            foreach ( $this->tableSchema['columns'] as $name => $attribute )
            {
                if ( !$this->database->issetColumnTable( $this->tableSchema['name'], $name ) )
                    $this->database->addColumn( $this->tableSchema['name'], $name . ' ' . $attribute );
            }
        }
    }

    private function init()
    {
        if ( !empty($this->sessionKey) )
            $data = $this->database->fetch( "SELECT * FROM `" . $this->tableSchema['name'] . "` WHERE `sessionKey` = '" . $this->sessionKey . "'" )[0];

        if ( empty( $data ) )
        {
          $this->model = new Session( $this->sessionKey, date('Y-m-d H:i:s'),  line( 'battle_start' ) );

          $this->database->insert(
              $this->tableSchema['name'],
              [ 'sessionKey' =>  $this->model->getKey(), 'dateCreate' => $this->model->getDateCreate(), 'battleLog' => line( 'battle_start' ) ]
          );
        }
        else
        {
            $this->model = new Session( $this->sessionKey, $data['dateCreate'], $data['battleLog'] );
        }
    }

    public function save()
    {
        $this->database->update(
            $this->tableSchema['name'],
            [ 'battleLog' => $this->model->getBattleLog(), 'dateCreate' => $this->model->getDateCreate() ],
            "`sessionKey` = '" . $this->model->getKey() . "'"
        );
    }

    public function delete()
    {
        $this->database->delete(
            $this->tableSchema['name'],
            "`sessionKey` = '" . $this->model->getKey() . "'"
        );
    }
}
?>
