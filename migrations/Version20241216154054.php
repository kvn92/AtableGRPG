<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216154054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, recettes_id INT DEFAULT NULL, users_id INT DEFAULT NULL, commentaires LONGTEXT NOT NULL, date_commentaire DATETIME NOT NULL, INDEX IDX_67F068BC3E2ED6D6 (recettes_id), INDEX IDX_67F068BC67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC3E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recette ADD categories_id INT DEFAULT NULL, ADD difficultes_id INT DEFAULT NULL, ADD repas_id INT DEFAULT NULL, ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB639073F3B3D4 FOREIGN KEY (difficultes_id) REFERENCES difficulte (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB63901D236AAA FOREIGN KEY (repas_id) REFERENCES type_repas (id)');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB639067B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_49BB6390A21214B7 ON recette (categories_id)');
        $this->addSql('CREATE INDEX IDX_49BB639073F3B3D4 ON recette (difficultes_id)');
        $this->addSql('CREATE INDEX IDX_49BB63901D236AAA ON recette (repas_id)');
        $this->addSql('CREATE INDEX IDX_49BB639067B3B43D ON recette (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC3E2ED6D6');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC67B3B43D');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390A21214B7');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB639073F3B3D4');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB63901D236AAA');
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB639067B3B43D');
        $this->addSql('DROP INDEX IDX_49BB6390A21214B7 ON recette');
        $this->addSql('DROP INDEX IDX_49BB639073F3B3D4 ON recette');
        $this->addSql('DROP INDEX IDX_49BB63901D236AAA ON recette');
        $this->addSql('DROP INDEX IDX_49BB639067B3B43D ON recette');
        $this->addSql('ALTER TABLE recette DROP categories_id, DROP difficultes_id, DROP repas_id, DROP users_id');
    }
}
