<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180413115746 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP INDEX email_UNIQUE ON client');
        $this->addSql('ALTER TABLE client DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE client ADD id INT AUTO_INCREMENT NOT NULL, DROP idClient, CHANGE lastname last_name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE client ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE driver DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE driver ADD id INT AUTO_INCREMENT NOT NULL, DROP idDriver, CHANGE Name name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE driver ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id_order INT NOT NULL, driver INT NOT NULL, client INT DEFAULT NULL, order_address VARCHAR(100) NOT NULL COLLATE utf8_general_ci, delivery_date DATE NOT NULL, delivery_hour INT NOT NULL, UNIQUE INDEX order_address_UNIQUE (order_address), INDEX id_driver_idx (driver), INDEX idClient_idx (client), PRIMARY KEY(id_order)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT idClient FOREIGN KEY (client) REFERENCES client (idClient) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT idDriver FOREIGN KEY (driver) REFERENCES driver (idDriver) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE client MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE client DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE client ADD idClient INT NOT NULL, DROP id, CHANGE last_name lastName VARCHAR(100) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('CREATE UNIQUE INDEX email_UNIQUE ON client (email)');
        $this->addSql('ALTER TABLE client ADD PRIMARY KEY (idClient)');
        $this->addSql('ALTER TABLE driver MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE driver DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE driver ADD idDriver INT NOT NULL, DROP id, CHANGE name Name VARCHAR(45) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE driver ADD PRIMARY KEY (idDriver)');
    }
}
