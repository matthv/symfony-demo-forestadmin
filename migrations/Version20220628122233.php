<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628122233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE car_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "check_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE driver_licence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, customer_id INT NOT NULL, car_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9395C3F3 ON booking (customer_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEC3C6F69F ON booking (car_id)');
        $this->addSql('CREATE TABLE car (id INT NOT NULL, category_id INT NOT NULL, reference VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, year INT NOT NULL, nb_seats INT NOT NULL, is_manual BOOLEAN NOT NULL, options JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_773DE69D12469DE2 ON car (category_id)');
        $this->addSql('CREATE TABLE car_check (car_id INT NOT NULL, check_id INT NOT NULL, PRIMARY KEY(car_id, check_id))');
        $this->addSql('CREATE INDEX IDX_E32529C4C3C6F69F ON car_check (car_id)');
        $this->addSql('CREATE INDEX IDX_E32529C4709385E7 ON car_check (check_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, label VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "check" (id INT NOT NULL, garage_name VARCHAR(100) NOT NULL, date DATE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIME(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "check".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE driver_licence (id INT NOT NULL, owner_id INT NOT NULL, reference VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D85582287E3C61F9 ON driver_licence (owner_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, remember_token DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car_check ADD CONSTRAINT FK_E32529C4C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car_check ADD CONSTRAINT FK_E32529C4709385E7 FOREIGN KEY (check_id) REFERENCES "check" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE driver_licence ADD CONSTRAINT FK_D85582287E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ALTER price SET DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDEC3C6F69F');
        $this->addSql('ALTER TABLE car_check DROP CONSTRAINT FK_E32529C4C3C6F69F');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT FK_773DE69D12469DE2');
        $this->addSql('ALTER TABLE car_check DROP CONSTRAINT FK_E32529C4709385E7');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE9395C3F3');
        $this->addSql('ALTER TABLE driver_licence DROP CONSTRAINT FK_D85582287E3C61F9');
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE car_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "check_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE driver_licence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_check');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE "check"');
        $this->addSql('DROP TABLE driver_licence');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE product ALTER price DROP DEFAULT');
    }
}
