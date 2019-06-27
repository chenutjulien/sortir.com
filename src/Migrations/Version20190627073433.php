<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190627073433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE trip CHANGE organiser_id organiser_id INT NOT NULL, CHANGE state_id state_id INT NOT NULL, CHANGE spot_id spot_id INT NOT NULL');
        $this->addSql('ALTER TABLE app_user CHANGE site_id site_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, username VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, firstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, picture VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, mail VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, administrator TINYINT(1) NOT NULL, active TINYINT(1) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_8D93D649F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE app_user CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip CHANGE organiser_id organiser_id INT DEFAULT NULL, CHANGE state_id state_id INT DEFAULT NULL, CHANGE spot_id spot_id INT DEFAULT NULL');
    }
}
