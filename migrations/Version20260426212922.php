<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260426212922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champions ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD passif LONGTEXT NOT NULL, ADD q LONGTEXT NOT NULL, ADD w LONGTEXT NOT NULL, ADD e LONGTEXT NOT NULL, ADD r LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE users ADD bio LONGTEXT DEFAULT NULL, ADD main_champion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E92EFC1F7D FOREIGN KEY (main_champion_id) REFERENCES champions (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E92EFC1F7D ON users (main_champion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champions DROP image_name, DROP updated_at, DROP passif, DROP q, DROP w, DROP e, DROP r');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E92EFC1F7D');
        $this->addSql('DROP INDEX IDX_1483A5E92EFC1F7D ON users');
        $this->addSql('ALTER TABLE users DROP bio, DROP main_champion_id');
    }
}
