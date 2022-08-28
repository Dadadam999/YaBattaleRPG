<?php
namespace YaGame;

class DataBase
{
     private $connection;
     private $tables = array();

     public function __construct()
     {
        $this->connection = new \PDO( 'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD );
        $this->setTables();
     }

     public function fetch( $query )
     {
        $result = $this->connection->prepare( $query );

        try
        {
            $result->execute();
        }
        catch (\PDOException $e)
        {
          return '';
        }

        if ( $result )
          return $result->fetchAll( \PDO::FETCH_ASSOC );

        return '';
     }

     private function setTables()
     {
        $tableNames = $this->fetch('SHOW TABLES')[0];

        foreach ( $tableNames as $tableName )
        {
            $columnResult = $this->fetch( "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . $tableName . "'" );

            foreach( $columnResult as $columnName )
                array_push( $this->tables, [ 'name' => $tableName , 'columns' => $columnName['COLUMN_NAME'] ] );
        }
     }

     public function issetTable( $name )
     {
        foreach ( $this->tables as $table )
           if ( $table['name'] === $name )
              return true;

        return false;
     }

     public function issetColumnTable( $tableName, $columnName )
     {
       foreach ( $this->tables as $table )
          if ( $table['name'] === $tableName && $table['columns'] === $columnName )
             return true;

       return false;
     }

     public function issetTableFetch( $name )
     {
        $result = $this->fetch( "SHOW TABLES FROM " . DB_NAME . " LIKE '" .$name . "'" );
        return !empty( $result );
     }

     public function issetColumnTableFetch( $table, $columnName )
     {
        $result = $this->fetch( "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . $table . "' AND COLUMN_NAME = '" . $columnName . "'" );
        return !empty( $result );
     }

     public function getTables()
     {
        return $this->tables;
     }

     public function insert( $table, $valuesColumns )
     {
        $sql= "INSERT INTO `" . $table . "` SET ";

        foreach ( $valuesColumns as $columns => $value )
            $sql .= "`" . $columns . "` = :" . $columns . ", ";

        $sql = substr($sql, 0, -2);
        $sql .= ' ';

        $result = $this->connection->prepare( $sql );
        $result->execute( $valuesColumns );
     }

     public function update( $table, $valuesColumns, $where )
     {
         $sql= "UPDATE `" . $table . "` SET ";

         foreach ( $valuesColumns as $columns => $value )
              $sql .= "`" . $columns . "` = :" . $columns . ", ";

         $sql = substr($sql, 0, -2);
         $sql .= " WHERE " . $where;
         $result = $this->connection->prepare( $sql );
         $result->execute( $valuesColumns );
     }

     public function delete( $table, $where )
     {
         $this->connection->exec( "DELETE FROM `" . $table . "` WHERE " . $where );
     }

     public function createTable( $name, $columns )
     {
        $sql = 'CREATE TABLE ' . $name;
        $sql .= '(';

        foreach ( $columns as $name => $attribute )
             $sql .= $name . ' ' . $attribute . ', ';

        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $this->connection->prepare( $sql )->execute();
     }

     public function addColumn( $table, $column )
     {
        $sql = 'ALTER TABLE ' . $table . ' ADD ' . $column;
        $this->connection->prepare( $sql )->execute();
     }

     public function addPrimaryColumn( $table, $columnName )
     {
        $sql = 'ALTER TABLE ' . $table . 'ADD PRIMARY KEY (' . $columnName . ')';
        $this->connection->prepare( $sql )->execute();
     }
}
?>
