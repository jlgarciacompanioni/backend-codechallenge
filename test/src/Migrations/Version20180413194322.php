<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180413194322 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `order` CHANGE delivery_date delivery_date DATE NOT NULL');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f5299398c3423909 TO IDX_3E89EBF7C3423909');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f529939819eb6921 TO IDX_3E89EBF719EB6921');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test.`order` CHANGE delivery_date delivery_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE test.`order` RENAME INDEX idx_3e89ebf7c3423909 TO IDX_F5299398C3423909');
        $this->addSql('ALTER TABLE test.`order` RENAME INDEX idx_3e89ebf719eb6921 TO IDX_F529939819EB6921');
    }
}
