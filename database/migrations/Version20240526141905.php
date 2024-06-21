<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526141905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Answer CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Answer ADD CONSTRAINT FK_DD714F13A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_DD714F13A76ED395 ON Answer (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Answer DROP FOREIGN KEY FK_DD714F13A76ED395');
        $this->addSql('DROP INDEX IDX_DD714F13A76ED395 ON Answer');
        $this->addSql('ALTER TABLE Answer CHANGE user_id user_id INT NOT NULL');
    }
}
