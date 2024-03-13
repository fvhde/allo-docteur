<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229192835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64923A564E6');
        $this->addSql('DROP INDEX IDX_8D93D64923A564E6 ON user');
        $this->addSql('ALTER TABLE user ADD hours LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP hours_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD hours_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', DROP hours');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64923A564E6 FOREIGN KEY (hours_id) REFERENCES hours (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64923A564E6 ON user (hours_id)');
    }
}
