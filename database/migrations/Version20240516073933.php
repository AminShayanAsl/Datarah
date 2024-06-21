<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516073933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, content LONGTEXT NOT NULL, comment LONGTEXT DEFAULT NULL, confirmation TINYINT(1) DEFAULT NULL, approval LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', disapproval LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', created_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_DD714F131E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Narration (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Question (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT NOT NULL, content LONGTEXT NOT NULL, comment LONGTEXT DEFAULT NULL, confirmation TINYINT(1) DEFAULT NULL, tags LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', approval LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', disapproval LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', created_at DATETIME NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, display_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2DA17977E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Answer ADD CONSTRAINT FK_DD714F131E27F6BF FOREIGN KEY (question_id) REFERENCES Question (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Answer DROP FOREIGN KEY FK_DD714F131E27F6BF');
        $this->addSql('DROP TABLE Answer');
        $this->addSql('DROP TABLE Narration');
        $this->addSql('DROP TABLE Question');
        $this->addSql('DROP TABLE User');
    }
}
