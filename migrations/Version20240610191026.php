<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610191026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, user_id INT NOT NULL, cursus_id INT NOT NULL, updated_at VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_6C3C6D75B03A8386 (created_by_id), INDEX IDX_6C3C6D75896DBBDE (updated_by_id), INDEX IDX_6C3C6D75A76ED395 (user_id), INDEX IDX_6C3C6D7540AEF4B9 (cursus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cursus (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, theme_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_255A0C3B03A8386 (created_by_id), INDEX IDX_255A0C3896DBBDE (updated_by_id), INDEX IDX_255A0C359027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, cursus_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, youtube_url VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, is_validated TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_F87474F3B03A8386 (created_by_id), INDEX IDX_F87474F3896DBBDE (updated_by_id), INDEX IDX_F87474F340AEF4B9 (cursus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, user_id INT NOT NULL, lesson_id INT DEFAULT NULL, cursus_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at VARCHAR(255) DEFAULT NULL, INDEX IDX_6117D13BB03A8386 (created_by_id), INDEX IDX_6117D13B896DBBDE (updated_by_id), INDEX IDX_6117D13BA76ED395 (user_id), INDEX IDX_6117D13BCDF80196 (lesson_id), INDEX IDX_6117D13B40AEF4B9 (cursus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9775E708B03A8386 (created_by_id), INDEX IDX_9775E708896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649B03A8386 (created_by_id), INDEX IDX_8D93D649896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D75B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D75896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D75A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D7540AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id)');
        $this->addSql('ALTER TABLE cursus ADD CONSTRAINT FK_255A0C3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cursus ADD CONSTRAINT FK_255A0C3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cursus ADD CONSTRAINT FK_255A0C359027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F340AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B40AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D75B03A8386');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D75896DBBDE');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D75A76ED395');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D7540AEF4B9');
        $this->addSql('ALTER TABLE cursus DROP FOREIGN KEY FK_255A0C3B03A8386');
        $this->addSql('ALTER TABLE cursus DROP FOREIGN KEY FK_255A0C3896DBBDE');
        $this->addSql('ALTER TABLE cursus DROP FOREIGN KEY FK_255A0C359027487');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3B03A8386');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3896DBBDE');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F340AEF4B9');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BB03A8386');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B896DBBDE');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BA76ED395');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BCDF80196');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B40AEF4B9');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708B03A8386');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708896DBBDE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B03A8386');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649896DBBDE');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE cursus');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
    }
}
