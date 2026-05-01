<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260427201839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champion_image (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, champion_id INT NOT NULL, INDEX IDX_774C5FF6FA7FD7EB (champion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE champion_passive (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE champion_spell (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, slot VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, tooltip LONGTEXT DEFAULT NULL, maxrank INT DEFAULT NULL, cooldown JSON DEFAULT NULL, cost JSON DEFAULT NULL, cooldown_burn VARCHAR(255) DEFAULT NULL, cost_burn VARCHAR(255) DEFAULT NULL, spell_range JSON DEFAULT NULL, range_burn VARCHAR(255) DEFAULT NULL, champion_id INT NOT NULL, INDEX IDX_624E9624FA7FD7EB (champion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE champion_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE champions_champion_tag (champions_id INT NOT NULL, champion_tag_id INT NOT NULL, INDEX IDX_DC1CD491D053F902 (champions_id), INDEX IDX_DC1CD491156A0906 (champion_tag_id), PRIMARY KEY (champions_id, champion_tag_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE champion_image ADD CONSTRAINT FK_774C5FF6FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champions (id)');
        $this->addSql('ALTER TABLE champion_spell ADD CONSTRAINT FK_624E9624FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champions (id)');
        $this->addSql('ALTER TABLE champions_champion_tag ADD CONSTRAINT FK_DC1CD491D053F902 FOREIGN KEY (champions_id) REFERENCES champions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE champions_champion_tag ADD CONSTRAINT FK_DC1CD491156A0906 FOREIGN KEY (champion_tag_id) REFERENCES champion_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE champions ADD champion_id VARCHAR(100) NOT NULL, ADD lore LONGTEXT DEFAULT NULL, ADD partype VARCHAR(100) DEFAULT NULL, ADD passive_id INT DEFAULT NULL, DROP image_name, DROP updated_at, DROP passif, DROP q, DROP w, DROP e, DROP r, CHANGE role title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE champions ADD CONSTRAINT FK_D747FBE06D157422 FOREIGN KEY (passive_id) REFERENCES champion_passive (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D747FBE06D157422 ON champions (passive_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion_image DROP FOREIGN KEY FK_774C5FF6FA7FD7EB');
        $this->addSql('ALTER TABLE champion_spell DROP FOREIGN KEY FK_624E9624FA7FD7EB');
        $this->addSql('ALTER TABLE champions_champion_tag DROP FOREIGN KEY FK_DC1CD491D053F902');
        $this->addSql('ALTER TABLE champions_champion_tag DROP FOREIGN KEY FK_DC1CD491156A0906');
        $this->addSql('DROP TABLE champion_image');
        $this->addSql('DROP TABLE champion_passive');
        $this->addSql('DROP TABLE champion_spell');
        $this->addSql('DROP TABLE champion_tag');
        $this->addSql('DROP TABLE champions_champion_tag');
        $this->addSql('ALTER TABLE champions DROP FOREIGN KEY FK_D747FBE06D157422');
        $this->addSql('DROP INDEX UNIQ_D747FBE06D157422 ON champions');
        $this->addSql('ALTER TABLE champions ADD image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD passif LONGTEXT NOT NULL, ADD q LONGTEXT NOT NULL, ADD w LONGTEXT NOT NULL, ADD e LONGTEXT NOT NULL, ADD r LONGTEXT NOT NULL, DROP champion_id, DROP lore, DROP partype, DROP passive_id, CHANGE title role VARCHAR(255) NOT NULL');
    }
}
