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

namespace Comwrap\Typo3\TwigForTypo3\Twig;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Adds the possibility to load twig files from TYPO3 extensions.
 */
class Typo3Loader implements \Twig_LoaderInterface
{
    /**
     * @var array
     */
    private $cache = [];

    /**
     * @var array
     */
    private $errorCache = [];

    public function getSourceContext($name)
    {
        $path = $this->findTemplate($name);

        return new \Twig_Source(\file_get_contents($path), $name, $path);
    }

    public function getCacheKey($name)
    {
        return $name;
    }

    public function isFresh($name, $time)
    {
        return \filemtime($this->findTemplate($name)) <= $time;
    }

    public function exists($name)
    {
        if (isset($this->cache[$name])) {
            return true;
        }

        return false !== $this->findTemplate($name, false);
    }

    /**
     * Checks if the template can be found.
     *
     * @param string $name  The template name
     * @param bool   $throw Whether to throw an exception when an error occurs
     *
     * @throws \Twig_Error_Loader
     *
     * @return false|string The template name or false
     */
    private function findTemplate(string $name, bool $throw = true): string
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        if (isset($this->errorCache[$name])) {
            if (!$throw) {
                return false;
            }
            throw new \Twig_Error_Loader($this->errorCache[$name]);
        }

        $path = GeneralUtility::getFileAbsFileName($name);

        if (!empty($path) && \is_file($path)) {
            return $this->cache[$name] = $path;
        }

        $this->errorCache[$name] = \sprintf('Unable to find template "%s".', $name);

        if (!$throw) {
            return false;
        }

        throw new \Twig_Error_Loader($this->errorCache[$name]);
    }
}
