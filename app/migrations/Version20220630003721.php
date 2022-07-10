<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630003721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE job_response (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, code INT NOT NULL, notes TEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_593CAE80BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(60) NOT NULL, code LONGTEXT DEFAULT NULL, start_date DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_response ADD CONSTRAINT FK_593CAE80BE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_response DROP FOREIGN KEY FK_593CAE80BE04EA9');
        $this->addSql('DROP TABLE job_response');
        $this->addSql('DROP TABLE jobs');
    }
}
