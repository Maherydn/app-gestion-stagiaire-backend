<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909162119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intern (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, university VARCHAR(255) NOT NULL, study_level VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, intership_demand VARCHAR(255) DEFAULT NULL, intership_authorization VARCHAR(255) DEFAULT NULL, intership_convention VARCHAR(255) DEFAULT NULL, intership_attestation VARCHAR(255) DEFAULT NULL, intership_number INT DEFAULT NULL, intership_start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', intership_finish_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', intership_duration VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL, ADD matricule INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE intern');
        $this->addSql('ALTER TABLE `user` DROP email, DROP matricule');
    }
}
