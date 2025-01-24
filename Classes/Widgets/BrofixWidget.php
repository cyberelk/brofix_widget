<?php

declare(strict_types=1);

namespace Cyberelk\BrofixWidget\Widgets;

use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;

class BrofixWidget implements WidgetInterface
{
    protected WidgetConfigurationInterface $configuration;
    protected StandaloneView $view;

    public function __construct(
        WidgetConfigurationInterface $configuration,
        StandaloneView $view,
    ) {
        $this->configuration = $configuration;
        $this->view = $view;
    }

    public function getOptions(): array
    {
        return [];
    }

    public function renderWidgetContent(): string
    {
        $this->view->setTemplate('Widget/BrofixWidget');

        $beUserAccess = true;
        /** @var BackendUserAuthentication $beUser */
        $beUser = $GLOBALS['BE_USER'];
        if (!$beUser->check('modules', 'web_brofix')) {
            // no output in case the user does not have access to the "brofix" module
            $beUserAccess = false;
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_brofix_broken_links');
        $brokenLinks = $queryBuilder
            ->select('*')
            ->from('tx_brofix_broken_links')
            ->executeQuery()
            ->fetchAllAssociative();

        // Define meaningful constants for the status values
        define('STATUS_FAULTY', '1');
        define('STATUS_OK', '2');
        define('STATUS_NOT_TESTABLE', '3');
        define('STATUS_EXCLUDED', '4');

        // Initialize counts array with predefined keys
        $countArray = [
            'faulty' => 0,
            'ok' => 0,
            'not_testable' => 0,
            'excluded' => 0,
            'unknown' => 0,
        ];

        // Mapping of status codes to array keys
        $statusMap = [
            STATUS_FAULTY => 'faulty',
            STATUS_OK => 'ok',
            STATUS_NOT_TESTABLE => 'not_testable',
            STATUS_EXCLUDED => 'excluded'
        ];

        foreach ($brokenLinks as $brokenLink) {
            if (isset($statusMap[$brokenLink['check_status']])) {
                $key = $statusMap[$brokenLink['check_status']];
                $countArray[$key]++;
            } else {
                $countArray['unknown']++;
            }
        }

        $this->view->assignMultiple([
            'countOverall' => $countArray['faulty'] + $countArray['not_testable'],
            'countArray' => $countArray,
            'beUserAccess' => $beUserAccess,
            'configuration' => $this->configuration,
        ]);
        return $this->view->render();
    }
}
