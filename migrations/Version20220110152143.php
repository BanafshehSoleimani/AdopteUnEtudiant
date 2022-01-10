<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220110152143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adoption (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, is_adopted TINYINT(1) NOT NULL, firstname_student VARCHAR(255) DEFAULT NULL, photo_student VARCHAR(255) DEFAULT NULL, INDEX IDX_EDDEB6A9979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4FBF094FE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, domain_id INT DEFAULT NULL, searchtype_id INT DEFAULT NULL, adoption_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, age INT NOT NULL, city VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, description LONGTEXT NOT NULL, cv VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, motivation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B723AF33E7927C74 (email), INDEX IDX_B723AF33115F0EE5 (domain_id), INDEX IDX_B723AF33E59D040F (searchtype_id), INDEX IDX_B723AF33631C55DF (adoption_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adoption ADD CONSTRAINT FK_EDDEB6A9979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33E59D040F FOREIGN KEY (searchtype_id) REFERENCES search_type (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33631C55DF FOREIGN KEY (adoption_id) REFERENCES adoption (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33631C55DF');
        $this->addSql('ALTER TABLE adoption DROP FOREIGN KEY FK_EDDEB6A9979B1AD6');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33115F0EE5');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33E59D040F');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE adoption');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE search_type');
        $this->addSql('DROP TABLE student');
    }
}
