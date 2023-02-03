<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230128195739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD created_at_timezone VARCHAR(100) DEFAULT \'UTC\', ADD updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE password_token ADD created_at_timezone VARCHAR(100) DEFAULT \'UTC\', ADD updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE place ADD created_at_timezone VARCHAR(100) DEFAULT \'UTC\', ADD updated_at_timezone VARCHAR(100) DEFAULT \'UTC\', CHANGE location location POINT NOT NULL');
        $this->addSql('ALTER TABLE speciality ADD created_at_timezone VARCHAR(100) DEFAULT \'UTC\', ADD updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE user ADD created_at_timezone VARCHAR(100) DEFAULT \'UTC\', ADD updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP created_at_timezone, DROP updated_at_timezone');
        $this->addSql('ALTER TABLE user DROP created_at_timezone, DROP updated_at_timezone');
        $this->addSql('ALTER TABLE speciality DROP created_at_timezone, DROP updated_at_timezone');
        $this->addSql('ALTER TABLE place DROP created_at_timezone, DROP updated_at_timezone, CHANGE location location JSON NOT NULL');
        $this->addSql('ALTER TABLE password_token DROP created_at_timezone, DROP updated_at_timezone');
    }
}
