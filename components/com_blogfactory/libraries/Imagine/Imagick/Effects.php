<?php

/**
-------------------------------------------------------------------------
blogfactory - Blog Factory 4.3.0
-------------------------------------------------------------------------
 * @author thePHPfactory
 * @copyright Copyright (C) 2011 SKEPSIS Consult SRL. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * Websites: http://www.thePHPfactory.com
 * Technical Support: Forum - http://www.thePHPfactory.com/forum/
-------------------------------------------------------------------------
*/

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imagine\Imagick;

defined('_JEXEC') or die;

use Imagine\Effects\EffectsInterface;
use Imagine\Exception\RuntimeException;
use Imagine\Image\Color;

/**
 * Effects implementation using the Imagick PHP extension
 */
class Effects implements EffectsInterface
{
    private $imagick;

    public function __construct(\Imagick $imagick)
    {
        $this->imagick = $imagick;
    }

    /**
     * {@inheritdoc}
     */
    public function gamma($correction)
    {
        try {
            $this->imagick->gammaImage($correction, \Imagick::CHANNEL_ALL);
        } catch (\ImagickException $e) {
            throw new RuntimeException('Failed to apply gamma correction to the image');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function negative()
    {
        try {
            $this->imagick->negateImage(false, \Imagick::CHANNEL_ALL);
        } catch (\ImagickException $e) {
            throw new RuntimeException('Failed to negate the image');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function grayscale()
    {
        try {
            $this->imagick->setImageType(\Imagick::IMGTYPE_GRAYSCALE);
        } catch (\ImagickException $e) {
            throw new RuntimeException('Failed to grayscale the image');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function colorize(Color $color)
    {
        try {
            $this->imagick->colorizeImage((string) $color, 1);
        } catch (\ImagickException $e) {
            throw new RuntimeException('Failed to colorize the image');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function sharpen()
    {
        try {
            $this->imagick->sharpenImage(2, 1);
        } catch (\ImagickException $e) {
            throw new RuntimeException('Failed to sharpen the image');
        }

        return $this;
    }
}
