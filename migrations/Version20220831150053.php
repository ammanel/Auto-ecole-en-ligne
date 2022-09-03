<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831150053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auto_ecole ADD horairedebut VARCHAR(255) NOT NULL, ADD horairefin VARCHAR(255) NOT NULL, DROP horaire_debut, DROP horaire_fin');
        $this->addSql('ALTER TABLE rapport ADD ap_rapport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CED6C497F FOREIGN KEY (ap_rapport_id) REFERENCES apprenant (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09CED6C497F ON rapport (ap_rapport_id)');
        $this->addSql('ALTER TABLE transaction ADD id_session_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C4B56C08 FOREIGN KEY (id_session_id) REFERENCES session (id)');
        $this->addSql('CREATE INDEX IDX_723705D1C4B56C08 ON transaction (id_session_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auto_ecole ADD horaire_debut VARCHAR(255) NOT NULL, ADD horaire_fin VARCHAR(255) NOT NULL, DROP horairedebut, DROP horairefin');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CED6C497F');
        $this->addSql('DROP INDEX IDX_BE34A09CED6C497F ON rapport');
        $this->addSql('ALTER TABLE rapport DROP ap_rapport_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C4B56C08');
        $this->addSql('DROP INDEX IDX_723705D1C4B56C08 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP id_session_id');
    }
}
