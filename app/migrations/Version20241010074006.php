<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010074006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // This method is called when migrating up
        $this->addSql("INSERT INTO `article` (`type`, `name`, `slug`, `keyword`) VALUES
            ('Snippet', 'Using Symfony validation outside of the form context', 'using-symfony-validation-outside-of-the-form-context', 'symfony,validation'),
            ('News', 'Breaking News: Major Event', 'breaking-news-major-event', 'news, event, breaking'),
            ('Blog', 'How to Cook the Perfect Steak', 'how-to-cook-perfect-steak', 'cooking, steak, food, blog'),
            ('Review', 'The Latest Smartphone Review', 'latest-smartphone-review', 'review, smartphone, technology'),
            ('Guide', 'Ultimate Travel Guide to Paris', 'ultimate-travel-guide-paris', 'travel, guide, Paris, vacation'),
            ('Tutorial', 'Learn Symfony 6: A Beginner’s Guide', 'learn-symfony-6-beginners-guide', 'Symfony, tutorial, PHP, guide'),
            ('Opinion', 'Why Electric Cars Are the Future', 'why-electric-cars-are-the-future', 'opinion, cars, electric, future'),
            ('Interview', 'Interview with a Tech Innovator', 'interview-tech-innovator', 'interview, technology, innovator'),
            ('List', 'Top 10 Programming Languages in 2024', 'top-10-programming-languages-2024', 'programming, languages, list'),
            ('Analysis', 'The Impact of AI on Jobs', 'impact-of-ai-on-jobs', 'AI, analysis, jobs, technology'),
            ('Feature', 'Exploring the World of Virtual Reality', 'exploring-virtual-reality', 'feature, VR, technology, future')
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
