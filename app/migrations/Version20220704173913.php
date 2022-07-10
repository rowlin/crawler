<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704173913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, token VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, chat_id VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE channel_bot (channel_id INT NOT NULL, bot_id INT NOT NULL, INDEX IDX_5CBAD3D572F5A1AA (channel_id), INDEX IDX_5CBAD3D592C1C487 (bot_id), PRIMARY KEY(channel_id, bot_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE channel_bot ADD CONSTRAINT FK_5CBAD3D572F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE channel_bot ADD CONSTRAINT FK_5CBAD3D592C1C487 FOREIGN KEY (bot_id) REFERENCES bot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jobs ADD notify TINYINT(1) NOT NULL, DROP start_date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE channel_bot DROP FOREIGN KEY FK_5CBAD3D592C1C487');
        $this->addSql('ALTER TABLE channel_bot DROP FOREIGN KEY FK_5CBAD3D572F5A1AA');
        $this->addSql('DROP TABLE bot');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_bot');
        $this->addSql('ALTER TABLE jobs ADD start_date DATETIME DEFAULT NULL, DROP notify');
    }
}
