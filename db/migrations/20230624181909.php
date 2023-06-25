<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class V20230624181909 extends AbstractMigration
{
    public function up(): void
    {
        $sql = <<<SQL
CREATE TABLE `customer_product` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `amount` INT(11) NOT NULL,
  PRIMARY KEY (`id`) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
SQL;
        $this->execute($sql);
    }

    public function down()
    {
        $sql = <<<SQL
DROP TABLE `customer_product`;
SQL;
        $this->execute($sql);
    }
}
