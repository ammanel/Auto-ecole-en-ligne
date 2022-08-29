<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220820193224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, jours_id INT DEFAULT NULL, session_id INT DEFAULT NULL, heure TIME NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, enable TINYINT(1) DEFAULT NULL, INDEX IDX_BBC83DB66180639B (jours_id), INDEX IDX_BBC83DB6613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jour (id INT AUTO_INCREMENT NOT NULL, jour VARCHAR(255) NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, auto_ecole_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, enable TINYINT(1) DEFAULT NULL, INDEX IDX_D044D5D4B1C987E1 (auto_ecole_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB66180639B FOREIGN KEY (jours_id) REFERENCES jour (id)');
        $this->addSql('ALTER TABLE horaire ADD CONSTRAINT FK_BBC83DB6613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4B1C987E1 FOREIGN KEY (auto_ecole_id) REFERENCES auto_ecole (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB66180639B');
        $this->addSql('ALTER TABLE horaire DROP FOREIGN KEY FK_BBC83DB6613FECDF');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4B1C987E1');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE jour');
        $this->addSql('DROP TABLE session');
    }
}
