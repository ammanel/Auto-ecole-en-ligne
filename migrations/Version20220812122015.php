<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220812122015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, prenom VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant (id INT NOT NULL, prenom VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, cours_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant_cours (apprenant_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_A3F510AC5697D6D (apprenant_id), INDEX IDX_A3F510A7ECF78B0 (cours_id), PRIMARY KEY(apprenant_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant_auto_ecole (apprenant_id INT NOT NULL, auto_ecole_id INT NOT NULL, INDEX IDX_627770E2C5697D6D (apprenant_id), INDEX IDX_627770E2B1C987E1 (auto_ecole_id), PRIMARY KEY(apprenant_id, auto_ecole_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auto_ecole (id INT NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, note DOUBLE PRECISION NOT NULL, horaire_debut VARCHAR(255) NOT NULL, horaire_fin VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choisir (id INT AUTO_INCREMENT NOT NULL, id_ecole INT NOT NULL, id_apprenant INT NOT NULL, date_inscription DATE NOT NULL, satut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu_cours LONGTEXT NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, typedoc_id INT DEFAULT NULL, date_etablissement DATE NOT NULL, enable TINYINT(1) DEFAULT NULL, INDEX IDX_D8698A76F2C56620 (compte_id), INDEX IDX_D8698A76D6223D7 (typedoc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mode_de_paiement (id INT AUTO_INCREMENT NOT NULL, nom_paiement VARCHAR(255) NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, nombre_heure INT NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, telephone VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, enable TINYINT(1) DEFAULT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FCEC9EF450FF010 (telephone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_apprenant (post_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_658538D94B89032C (post_id), INDEX IDX_658538D9C5697D6D (apprenant_id), PRIMARY KEY(post_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, suggestion VARCHAR(255) NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, cours_dedie_id INT DEFAULT NULL, intitule VARCHAR(255) NOT NULL, enable TINYINT(1) DEFAULT NULL, INDEX IDX_B6F7494EBD26FFD4 (cours_dedie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_proposition (question_id INT NOT NULL, proposition_id INT NOT NULL, INDEX IDX_24C91CDE1E27F6BF (question_id), INDEX IDX_24C91CDEDB96F9E (proposition_id), PRIMARY KEY(question_id, proposition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rappel (id INT AUTO_INCREMENT NOT NULL, id_doc_id INT DEFAULT NULL, date_expiration DATE NOT NULL, INDEX IDX_303A29C9AF61FD51 (id_doc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, createur_id INT DEFAULT NULL, date_crea DATE NOT NULL, time_crea TIME NOT NULL, contenu LONGTEXT NOT NULL, INDEX IDX_BE34A09C73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, id_pack_id INT DEFAULT NULL, id_mode_payement_id INT DEFAULT NULL, id_apprenant_id INT DEFAULT NULL, type_de_payement VARCHAR(255) NOT NULL, cours TINYINT(1) DEFAULT NULL, INDEX IDX_723705D1C7841B67 (id_pack_id), INDEX IDX_723705D1CC54CC3 (id_mode_payement_id), INDEX IDX_723705D1E6A8081F (id_apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, duree INT NOT NULL, enable TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voir (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, apprenant_id INT NOT NULL, datevisualisation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EBF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_cours ADD CONSTRAINT FK_A3F510AC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_cours ADD CONSTRAINT FK_A3F510A7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_auto_ecole ADD CONSTRAINT FK_627770E2C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_auto_ecole ADD CONSTRAINT FK_627770E2B1C987E1 FOREIGN KEY (auto_ecole_id) REFERENCES auto_ecole (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auto_ecole ADD CONSTRAINT FK_FD0557BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76F2C56620 FOREIGN KEY (compte_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76D6223D7 FOREIGN KEY (typedoc_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE post_apprenant ADD CONSTRAINT FK_658538D94B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_apprenant ADD CONSTRAINT FK_658538D9C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBD26FFD4 FOREIGN KEY (cours_dedie_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE question_proposition ADD CONSTRAINT FK_24C91CDE1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_proposition ADD CONSTRAINT FK_24C91CDEDB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rappel ADD CONSTRAINT FK_303A29C9AF61FD51 FOREIGN KEY (id_doc_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C73A201E5 FOREIGN KEY (createur_id) REFERENCES auto_ecole (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C7841B67 FOREIGN KEY (id_pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CC54CC3 FOREIGN KEY (id_mode_payement_id) REFERENCES mode_de_paiement (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1E6A8081F FOREIGN KEY (id_apprenant_id) REFERENCES apprenant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_cours DROP FOREIGN KEY FK_A3F510AC5697D6D');
        $this->addSql('ALTER TABLE apprenant_auto_ecole DROP FOREIGN KEY FK_627770E2C5697D6D');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76F2C56620');
        $this->addSql('ALTER TABLE post_apprenant DROP FOREIGN KEY FK_658538D9C5697D6D');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1E6A8081F');
        $this->addSql('ALTER TABLE apprenant_auto_ecole DROP FOREIGN KEY FK_627770E2B1C987E1');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C73A201E5');
        $this->addSql('ALTER TABLE apprenant_cours DROP FOREIGN KEY FK_A3F510A7ECF78B0');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBD26FFD4');
        $this->addSql('ALTER TABLE rappel DROP FOREIGN KEY FK_303A29C9AF61FD51');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CC54CC3');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C7841B67');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EBF396750');
        $this->addSql('ALTER TABLE auto_ecole DROP FOREIGN KEY FK_FD0557BF396750');
        $this->addSql('ALTER TABLE post_apprenant DROP FOREIGN KEY FK_658538D94B89032C');
        $this->addSql('ALTER TABLE question_proposition DROP FOREIGN KEY FK_24C91CDEDB96F9E');
        $this->addSql('ALTER TABLE question_proposition DROP FOREIGN KEY FK_24C91CDE1E27F6BF');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76D6223D7');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE apprenant_cours');
        $this->addSql('DROP TABLE apprenant_auto_ecole');
        $this->addSql('DROP TABLE auto_ecole');
        $this->addSql('DROP TABLE choisir');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE mode_de_paiement');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_apprenant');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_proposition');
        $this->addSql('DROP TABLE rappel');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE type_document');
        $this->addSql('DROP TABLE voir');
    }
}
