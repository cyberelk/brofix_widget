<?php

use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

defined('TYPO3') || die;

(static function () {
    ExtensionManagementUtility::addTypoScript(
        'brofix_widget',
        'setup',
        "@import 'EXT:brofix_widget/Configuration/TypoScript/setup.typoscript'"
    );

    $iconRegistry = GeneralUtility::makeInstance(
        IconRegistry::class
    );
    $iconRegistry->registerIcon(
        'extension-brofix',
        SvgIconProvider::class,
        ['source' => 'EXT:brofix/Resources/Public/Icons/Extension.svg']
    );

})();
