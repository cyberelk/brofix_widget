<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

ExtensionManagementUtility::addStaticFile('brofix_widget', 'Configuration/TypoScript', 'Brofix Widget');
