<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216155440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE place (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, phone VARCHAR(100) DEFAULT NULL, location JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, required_documents JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', place_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) DEFAULT NULL, phone VARCHAR(100) DEFAULT NULL, first_name VARCHAR(150) NOT NULL, last_name VARCHAR(150) NOT NULL, gender VARCHAR(10) NOT NULL, birthday DATETIME NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, hours JSON DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649444F97DD (phone), INDEX IDX_8D93D649DA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professionals_specialities (professional_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', speciality_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_5C0F4BFEDB77003 (professional_id), INDEX IDX_5C0F4BFE3B5A08D7 (speciality_id), PRIMARY KEY(professional_id, speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE professionals_specialities ADD CONSTRAINT FK_5C0F4BFEDB77003 FOREIGN KEY (professional_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professionals_specialities ADD CONSTRAINT FK_5C0F4BFE3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointment ADD place_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD professional_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD patient_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', ADD speciality_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844DB77003 FOREIGN KEY (professional_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8443B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('CREATE INDEX IDX_FE38F844DA6A219 ON appointment (place_id)');
        $this->addSql('CREATE INDEX IDX_FE38F844DB77003 ON appointment (professional_id)');
        $this->addSql('CREATE INDEX IDX_FE38F8446B899279 ON appointment (patient_id)');
        $this->addSql('CREATE INDEX IDX_FE38F8443B5A08D7 ON appointment (speciality_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844DA6A219');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8443B5A08D7');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844DB77003');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DA6A219');
        $this->addSql('ALTER TABLE professionals_specialities DROP FOREIGN KEY FK_5C0F4BFEDB77003');
        $this->addSql('ALTER TABLE professionals_specialities DROP FOREIGN KEY FK_5C0F4BFE3B5A08D7');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE professionals_specialities');
        $this->addSql('DROP INDEX IDX_FE38F844DA6A219 ON appointment');
        $this->addSql('DROP INDEX IDX_FE38F844DB77003 ON appointment');
        $this->addSql('DROP INDEX IDX_FE38F8446B899279 ON appointment');
        $this->addSql('DROP INDEX IDX_FE38F8443B5A08D7 ON appointment');
        $this->addSql('ALTER TABLE appointment DROP place_id, DROP professional_id, DROP patient_id, DROP speciality_id');
    }
}
