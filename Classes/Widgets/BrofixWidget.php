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

        $this->view->assignMultiple([
            'count' => count($brokenLinks),
            'beUserAccess' => $beUserAccess,
            'configuration' => $this->configuration,
        ]);
        return $this->view->render();
    }
}
