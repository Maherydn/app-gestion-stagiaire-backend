<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240909171634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intern ADD user_id INT DEFAULT NULL, ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intern ADD CONSTRAINT FK_A5795F36A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE intern ADD CONSTRAINT FK_A5795F36CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_A5795F36A76ED395 ON intern (user_id)');
        $this->addSql('CREATE INDEX IDX_A5795F36CCF9E01E ON intern (departement_id)');
        $this->addSql('ALTER TABLE user ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CCF9E01E ON user (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intern DROP FOREIGN KEY FK_A5795F36A76ED395');
        $this->addSql('ALTER TABLE intern DROP FOREIGN KEY FK_A5795F36CCF9E01E');
        $this->addSql('DROP INDEX IDX_A5795F36A76ED395 ON intern');
        $this->addSql('DROP INDEX IDX_A5795F36CCF9E01E ON intern');
        $this->addSql('ALTER TABLE intern DROP user_id, DROP departement_id');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CCF9E01E');
        $this->addSql('DROP INDEX IDX_8D93D649CCF9E01E ON `user`');
        $this->addSql('ALTER TABLE `user` DROP departement_id');
    }
}
