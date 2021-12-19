<?php

declare(strict_types=1);

/*
 * This file is part of migration of calendar_feature for Contao Open Source CMS.
 *
 * (c) bwein.net
 *
 * @license MIT
 */

namespace Bwein\MigrateCalendarFeature\Migration;

use Contao\CoreBundle\Migration\MigrationInterface;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class CalendarFeaturedMigration implements MigrationInterface
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        if (null === $schemaManager || !$schemaManager->tablesExist(['tl_module'])) {
            return false;
        }

        $columns = $schemaManager->listTableColumns('tl_module');

        return isset($columns['events_featured'], $columns['cal_featured']);
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function run(): MigrationResult
    {
        // Get current data
        $statement = $this->connection->executeQuery(
            "SELECT id, events_featured FROM tl_module WHERE events_featured != ''"
        );

        // Migrate data
        while (false !== ($row = $statement->fetchAssociative())) {
            $cal_featured = $row['events_featured'];

            switch ($row['events_featured']) {
                case 'all_events':
                    $cal_featured = 'all_items';
                    break;

                case 'featured_events':
                    $cal_featured = 'featured';
                    break;

                case 'unfeatured_events':
                    $cal_featured = 'unfeatured';
                    break;
            }

            $stmt = $this->connection->prepare(
                '
                UPDATE
                    tl_module
                SET
                    cal_featured = :cal_featured
                WHERE
                    id = :id
            '
            );

            $stmt->executeStatement(
                [
                    ':id' => $row['id'],
                    ':cal_featured' => $cal_featured,
                ]
            );
        }

        // Remove the database fields
        $this->connection->executeQuery('
            ALTER TABLE
                tl_module
            DROP
                events_featured
        ');

        return new MigrationResult(true, $this->getName().' successful');
    }

    public function getName(): string
    {
        return 'Calendar Featured Migration';
    }
}
