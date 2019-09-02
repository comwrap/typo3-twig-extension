<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Twig for TYPO3',
    'description' => 'Integrates the Twig template engine into TYPO3 CMS.',
    'category' => 'fe',
    'author' => 'comwrap GmbH',
    'author_email' => 'opensource@comwrap.com',
    'state' => 'stable',
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-9.5.99',
        ],
    ],
];
