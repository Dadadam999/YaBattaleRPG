<?php
namespace YaGame\Controllers;

use YaGame\Interfaces\ITable;
use YaGame\Models\Person;
use YaGame\DataBase;

class PersonTable implements ITable
{
    public $model;
    private $database;
    private $sessionKey;
    private $personName;

    private $tableSchema = [
        'name' => DB_PREFIX . 'persones',
        'columns' => [
              'id' => 'INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT',
              'sessionKey' => 'varchar(1024)',
              'name' => 'varchar(256)',
              'attack' => 'INT(11)',
              'health' => 'INT(11)',
              'protect' => 'INT(11)',
              'increase' => 'INT(11)',
        ]
    ];

    public function __construct( DataBase $database, $sessionKey, $personName )
    {
        $this->database = $database;
        $this->sessionKey = $sessionKey;
        $this->personName = $personName;

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
            $data = $this->database->fetch( "SELECT * FROM `" . $this->tableSchema['name'] . "` WHERE `sessionKey` = '" . $this->sessionKey .  "' AND `name` = '" . $this->personName . "'" )[0];

        if ( empty( $data ) )
        {
            $this->model = new Person( $this->personName, PERSON_SETTINGS[$this->personName . '_attack'], PERSON_SETTINGS[$this->personName . '_health'], PERSON_SETTINGS[$this->personName . '_protect'], PERSON_SETTINGS[$this->personName . '_increase'] );

            $this->database->insert(
                $this->tableSchema['name'],
                [ 'sessionKey' =>  $this->sessionKey, 'name' => $this->model->getName(), 'attack' => $this->model->getAttack() , 'health' => $this->model->getHealth(), 'protect' => $this->model->getProtect(), 'increase' => $this->model->getIncrease() ]
            );
        }
        else
        {
            $this->model = new Person( $this->personName, $data['attack'], $data['health'], $data['protect'], $data['increase'] );
        }
    }

    public function save()
    {
        $this->database->update(
            $this->tableSchema['name'],
            [ 'attack' => $this->model->getAttack() , 'health' => $this->model->getHealth(), 'protect' => $this->model->getProtect() , 'increase' => $this->model->getIncrease() ],
            "`sessionKey` = '" . $this->sessionKey .  "' AND `name` = '" . $this->model->getName() . "'"
        );
    }

    public function delete()
    {
        $this->database->delete(
            $this->tableSchema['name'],
            "`sessionKey` = '" . $this->sessionKey .  "' AND `name` = '" . $this->model->getName() . "'"
        );
    }
}
?>
