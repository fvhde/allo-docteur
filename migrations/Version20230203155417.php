<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203155417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment ADD status VARCHAR(100) DEFAULT \'created\', CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT NULL, CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE password_token CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT NULL, CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE place CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT NULL, CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT NULL, CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT NULL, CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT \'UTC\', CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE password_token CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT \'UTC\', CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE place CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT \'UTC\', CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE speciality CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT \'UTC\', CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
        $this->addSql('ALTER TABLE appointment DROP status, CHANGE created_at_timezone created_at_timezone VARCHAR(100) DEFAULT \'UTC\', CHANGE updated_at_timezone updated_at_timezone VARCHAR(100) DEFAULT \'UTC\'');
    }
}
