<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190627143722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE rememberme_token');
        $this->addSql('ALTER TABLE tripback ADD end_date_time DATETIME NOT NULL, DROP duration');
        $this->addSql('ALTER TABLE app_user ADD roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP picture, CHANGE site_id site_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rememberme_token (id INT AUTO_INCREMENT NOT NULL, series VARCHAR(88) NOT NULL COLLATE utf8mb4_unicode_ci, value VARCHAR(88) NOT NULL COLLATE utf8mb4_unicode_ci, lastUsed DATETIME NOT NULL, class VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, username VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE app_user ADD picture VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP roles, CHANGE site_id site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tripback ADD duration DOUBLE PRECISION NOT NULL, DROP end_date_time');
    }
}
