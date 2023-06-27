<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class V20230625073113 extends AbstractMigration
{

    public function up(): void
    {
        $sql = <<<SQL
CREATE TABLE `customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
SQL;
        $this->execute($sql);
    }

    public function down()
    {
        $sql = <<<SQL
DROP TABLE `customer`;
SQL;
        $this->execute($sql);
    }
}
