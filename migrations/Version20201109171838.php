<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109171838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pizza_order DROP FOREIGN KEY FK_PIZZAORDER_ORDERSTATUS');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('ALTER TABLE pizza_combination CHANGE price_cent price_cent SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE pizza_ingredient CHANGE price_cent price_cent SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE pizza_order DROP FOREIGN KEY FK_PIZZAORDER_CUSTOMER');
        $this->addSql('DROP INDEX FK_PIZZAORDER_CUSTOMER ON pizza_order');
        $this->addSql('DROP INDEX FK_PIZZAORDER_ORDERSTATUS ON pizza_order');
        $this->addSql('ALTER TABLE pizza_order CHANGE order_date order_date DATETIME NOT NULL, CHANGE total_price_dollar price_dollar INT NOT NULL, CHANGE total_price_cent price_cent SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE pizza_order_line DROP FOREIGN KEY FK_PIZZAORDERLINE_PIZZAORDER');
        $this->addSql('ALTER TABLE pizza_order_line DROP FOREIGN KEY FK_PIZZAORDERLINE_PIZZASIZE');
        $this->addSql('DROP INDEX FK_PIZZAORDERLINE_PIZZACOMBINATION ON pizza_order_line');
        $this->addSql('DROP INDEX FK_PIZZAORDERLINE_PIZZAORDER ON pizza_order_line');
        $this->addSql('DROP INDEX FK_PIZZAORDERLINE_PIZZASIZE ON pizza_order_line');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, UNIQUE INDEX status (status), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pizza_combination CHANGE price_cent price_cent INT NOT NULL');
        $this->addSql('ALTER TABLE pizza_ingredient CHANGE price_cent price_cent INT NOT NULL');
        $this->addSql('ALTER TABLE pizza_order CHANGE order_date order_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE price_dollar total_price_dollar INT NOT NULL, CHANGE price_cent total_price_cent SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE pizza_order ADD CONSTRAINT FK_PIZZAORDER_CUSTOMER FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE pizza_order ADD CONSTRAINT FK_PIZZAORDER_ORDERSTATUS FOREIGN KEY (order_status_id) REFERENCES order_status (id)');
        $this->addSql('CREATE INDEX FK_PIZZAORDER_CUSTOMER ON pizza_order (customer_id)');
        $this->addSql('CREATE INDEX FK_PIZZAORDER_ORDERSTATUS ON pizza_order (order_status_id)');
        $this->addSql('ALTER TABLE pizza_order_line ADD CONSTRAINT FK_PIZZAORDERLINE_PIZZAORDER FOREIGN KEY (pizza_order_id) REFERENCES pizza_order (id)');
        $this->addSql('ALTER TABLE pizza_order_line ADD CONSTRAINT FK_PIZZAORDERLINE_PIZZASIZE FOREIGN KEY (pizza_size_id) REFERENCES pizza_size (id)');
        $this->addSql('CREATE INDEX FK_PIZZAORDERLINE_PIZZACOMBINATION ON pizza_order_line (pizza_combination_id)');
        $this->addSql('CREATE INDEX FK_PIZZAORDERLINE_PIZZAORDER ON pizza_order_line (pizza_order_id)');
        $this->addSql('CREATE INDEX FK_PIZZAORDERLINE_PIZZASIZE ON pizza_order_line (pizza_size_id)');
    }
}
