<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260218190833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE champions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id INT NOT NULL, topic_id INT NOT NULL, INDEX IDX_885DBAFAA76ED395 (user_id), INDEX IDX_885DBAFA1F55203D (topic_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, is_pinned TINYINT NOT NULL, is_locked TINYINT NOT NULL, category_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_91F6463912469DE2 (category_id), INDEX IDX_91F64639F675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_settings (id INT AUTO_INCREMENT NOT NULL, theme VARCHAR(255) NOT NULL, topic_answers TINYINT NOT NULL, topic_ask TINYINT NOT NULL, upvotes TINYINT NOT NULL, shares TINYINT NOT NULL, moderation TINYINT NOT NULL, messages TINYINT NOT NULL, comments TINYINT NOT NULL, replies TINYINT NOT NULL, mentions TINYINT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_5C844C5A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, ranks VARCHAR(255) DEFAULT NULL, positions VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, about_me LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE votes (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, user_id INT NOT NULL, post_id INT DEFAULT NULL, topic_id INT DEFAULT NULL, INDEX IDX_518B7ACFA76ED395 (user_id), INDEX IDX_518B7ACF4B89032C (post_id), INDEX IDX_518B7ACF1F55203D (topic_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA1F55203D FOREIGN KEY (topic_id) REFERENCES topics (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F6463912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_settings ADD CONSTRAINT FK_5C844C5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF1F55203D FOREIGN KEY (topic_id) REFERENCES topics (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA1F55203D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F6463912469DE2');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639F675F31B');
        $this->addSql('ALTER TABLE user_settings DROP FOREIGN KEY FK_5C844C5A76ED395');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACFA76ED395');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF4B89032C');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF1F55203D');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE champions');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE topics');
        $this->addSql('DROP TABLE user_settings');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE votes');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
