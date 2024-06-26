<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511184727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, data JSON NOT NULL, UNIQUE INDEX UNIQ_6EA9A146A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE main_note (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(32) NOT NULL, INDEX IDX_2F0EC876A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_note (id INT AUTO_INCREMENT NOT NULL, main_note_id INT NOT NULL, title VARCHAR(32) NOT NULL, html LONGTEXT NOT NULL, INDEX IDX_E82B65D5D2A6A1BC (main_note_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, surname VARCHAR(32) NOT NULL, email VARCHAR(32) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A146A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE main_note ADD CONSTRAINT FK_2F0EC876A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sub_note ADD CONSTRAINT FK_E82B65D5D2A6A1BC FOREIGN KEY (main_note_id) REFERENCES main_note (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A146A76ED395');
        $this->addSql('ALTER TABLE main_note DROP FOREIGN KEY FK_2F0EC876A76ED395');
        $this->addSql('ALTER TABLE sub_note DROP FOREIGN KEY FK_E82B65D5D2A6A1BC');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE main_note');
        $this->addSql('DROP TABLE sub_note');
        $this->addSql('DROP TABLE `user`');
    }
}
