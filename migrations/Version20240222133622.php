<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222133622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hours (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, created_at_timezone VARCHAR(100) DEFAULT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at_timezone VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD end_at DATETIME DEFAULT NULL, CHANGE date begin_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD hours_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', DROP hours');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64923A564E6 FOREIGN KEY (hours_id) REFERENCES hours (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64923A564E6 ON user (hours_id)');
        $this->addSql('ALTER TABLE hours ADD data LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD opening_hours LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD exceptions LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD filters LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD timezone DATETIME NOT NULL, ADD output_timezone DATETIME NOT NULL, ADD overflow TINYINT(1) NOT NULL, ADD day_limit TINYINT(1) NOT NULL, ADD date_time_class VARCHAR(255) NOT NULL');
        $this->addSql('CREATE TABLE professional_speciality (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', professional_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', speciality_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', duration INT NOT NULL, INDEX IDX_C4BAD837DB77003 (professional_id), INDEX IDX_C4BAD8373B5A08D7 (speciality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE professional_speciality ADD CONSTRAINT FK_C4BAD837DB77003 FOREIGN KEY (professional_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE professional_speciality ADD CONSTRAINT FK_C4BAD8373B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('ALTER TABLE professionals_specialities DROP FOREIGN KEY FK_5C0F4BFEDB77003');
        $this->addSql('ALTER TABLE professionals_specialities DROP FOREIGN KEY FK_5C0F4BFE3B5A08D7');
        $this->addSql('DROP TABLE professionals_specialities');
        $this->addSql('ALTER TABLE user ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64923A564E6');
        $this->addSql('DROP TABLE hours');
        $this->addSql('ALTER TABLE appointment DROP end_at, CHANGE begin_at date DATETIME NOT NULL');
        $this->addSql('DROP INDEX IDX_8D93D64923A564E6 ON user');
        $this->addSql('ALTER TABLE user ADD hours JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', DROP hours_id');
        $this->addSql('ALTER TABLE hours DROP data, DROP opening_hours, DROP exceptions, DROP filters, DROP timezone, DROP output_timezone, DROP overflow, DROP day_limit, DROP date_time_class');
        $this->addSql('CREATE TABLE professionals_specialities (professional_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', speciality_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_5C0F4BFEDB77003 (professional_id), INDEX IDX_5C0F4BFE3B5A08D7 (speciality_id), PRIMARY KEY(professional_id, speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE professionals_specialities ADD CONSTRAINT FK_5C0F4BFEDB77003 FOREIGN KEY (professional_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professionals_specialities ADD CONSTRAINT FK_5C0F4BFE3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professional_speciality DROP FOREIGN KEY FK_C4BAD837DB77003');
        $this->addSql('ALTER TABLE professional_speciality DROP FOREIGN KEY FK_C4BAD8373B5A08D7');
        $this->addSql('DROP TABLE professional_speciality');
        $this->addSql('ALTER TABLE user DROP description');
    }
}
