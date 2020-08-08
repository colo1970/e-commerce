<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807215413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, validation TINYINT(1) NOT NULL, date_at DATETIME NOT NULL, reference INT NOT NULL, panier LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_35D4282CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, categorie_id INT NOT NULL, tva_id INT NOT NULL, nom VARCHAR(100) NOT NULL, prixht DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, quantite DOUBLE PRECISION DEFAULT NULL, poids DOUBLE PRECISION DEFAULT NULL, disponibilite TINYINT(1) NOT NULL, date_crea_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_BE2DDF8C3DA5256D (image_id), INDEX IDX_BE2DDF8CBCF5E72D (categorie_id), INDEX IDX_BE2DDF8C4D79775F (tva_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tva (id INT AUTO_INCREMENT NOT NULL, multiplicateur DOUBLE PRECISION NOT NULL, nom VARCHAR(50) NOT NULL, valeur DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_adresses (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, telephone VARCHAR(50) NOT NULL, cp VARCHAR(50) NOT NULL, adresse VARCHAR(10) NOT NULL, ville VARCHAR(50) NOT NULL, pays VARCHAR(50) NOT NULL, complements VARCHAR(255) DEFAULT NULL, date_cre_at DATETIME NOT NULL, INDEX IDX_F94C152A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C4D79775F FOREIGN KEY (tva_id) REFERENCES tva (id)');
        $this->addSql('ALTER TABLE user_adresses ADD CONSTRAINT FK_F94C152A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CBCF5E72D');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C3DA5256D');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C4D79775F');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE tva');
        $this->addSql('DROP TABLE user_adresses');
    }
}
