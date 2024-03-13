<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304093947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE opening_hour (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', professional_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', day VARCHAR(255) NOT NULL, opened TINYINT(1) NOT NULL, `from` VARCHAR(255) DEFAULT NULL, `to` VARCHAR(255) DEFAULT NULL, INDEX IDX_969BD765DB77003 (professional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE opening_hour ADD CONSTRAINT FK_969BD765DB77003 FOREIGN KEY (professional_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP hours');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) DEFAULT NULL, DROP avatar_name, DROP avatar_path');
        $this->addSql('DROP TABLE hours');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opening_hour DROP FOREIGN KEY FK_969BD765DB77003');
        $this->addSql('DROP TABLE opening_hour');
        $this->addSql('ALTER TABLE user ADD hours LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE user ADD avatar_path VARCHAR(255) DEFAULT NULL, CHANGE avatar avatar_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE TABLE hours (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, created_at_timezone VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at_timezone VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, data LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:simple_array)\', opening_hours LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:simple_array)\', exceptions LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:simple_array)\', filters LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:simple_array)\', timezone DATETIME NOT NULL, output_timezone DATETIME NOT NULL, overflow TINYINT(1) NOT NULL, day_limit TINYINT(1) NOT NULL, date_time_class VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
    }
}
