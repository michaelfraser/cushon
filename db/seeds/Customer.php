<?php

use Phinx\Seed\AbstractSeed;

class Customer extends AbstractSeed
{
    public function run()
    {
        $sql = <<<SQL
    INSERT INTO `customer`
        (`id`, `name`, `last_name`) 
    VALUES 
        (1, 'Michael', 'Fraser'),
        (2, 'John', 'Doe')
    ;
SQL;
        $this->execute($sql);
    }
}
