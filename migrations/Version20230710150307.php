<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710150307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE coupon (id SERIAL NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F0277153098 ON coupon (code)');
        $this->addSql('CREATE TABLE product (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE purchase (id SERIAL NOT NULL, product_id INT NOT NULL, coupon_id INT DEFAULT NULL, tax_id INT NOT NULL, tax_number VARCHAR(255) NOT NULL, payment_processor VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6117D13B4584665A ON purchase (product_id)');
        $this->addSql('CREATE INDEX IDX_6117D13B66C5951B ON purchase (coupon_id)');
        $this->addSql('CREATE INDEX IDX_6117D13BB2A824D8 ON purchase (tax_id)');
        $this->addSql('CREATE TABLE tax (id SERIAL NOT NULL, county_code VARCHAR(255) NOT NULL, value INT NOT NULL, terminated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E81BA7625103594 ON tax (county_code) WHERE (terminated_at IS NULL)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B66C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13B4584665A');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13B66C5951B');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13BB2A824D8');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE tax');
    }
}
