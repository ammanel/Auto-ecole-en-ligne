<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220810005858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mode_de_paiement (id INT AUTO_INCREMENT NOT NULL, nom_paiement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, nombre_heure INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, id_pack_id INT DEFAULT NULL, id_mode_payement_id INT DEFAULT NULL, id_apprenant_id INT DEFAULT NULL, type_de_payement VARCHAR(255) NOT NULL, cours TINYINT(1) DEFAULT NULL, INDEX IDX_723705D1C7841B67 (id_pack_id), INDEX IDX_723705D1CC54CC3 (id_mode_payement_id), INDEX IDX_723705D1E6A8081F (id_apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C7841B67 FOREIGN KEY (id_pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CC54CC3 FOREIGN KEY (id_mode_payement_id) REFERENCES mode_de_paiement (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1E6A8081F FOREIGN KEY (id_apprenant_id) REFERENCES apprenant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CC54CC3');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C7841B67');
        $this->addSql('DROP TABLE mode_de_paiement');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE transaction');
    }
}
