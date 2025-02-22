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

namespace Imagine\Filter\Advanced;

defined('_JEXEC') or die;

use Imagine\Filter\FilterInterface;
use Imagine\Image\ImageInterface;
use Imagine\Image\Color;
use Imagine\Image\Point;

/**
 * A border filter
 */
class Border implements FilterInterface
{
    /**
     * @var Color
     */
    private $color;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * Constructs Border filter with given color, width and height
     *
     * @param Color   $color
     * @param integer $width  Width of the border on the left and right sides of the image
     * @param integer $height Height of the border on the top and bottom sides of the image
     */
    public function __construct(Color $color, $width = 1, $height = 1)
    {
        $this->color = $color;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        $size = $image->getSize();
        $width = $size->getWidth();
        $height = $size->getHeight();

        $draw = $image->draw();

        // Draw top and bottom lines
        $draw
            ->line(
                new Point(0, 0),
                new Point($width - 1, 0),
                $this->color,
                $this->height
            )
            ->line(
                new Point($width - 1, $height - 1),
                new Point(0, $height - 1),
                $this->color,
                $this->height
            )
        ;

        // Draw sides
        $draw
            ->line(
                new Point(0, 0),
                new Point(0, $height - 1),
                $this->color,
                $this->width
            )
            ->line(
                new Point($width - 1, 0),
                new Point($width - 1, $height - 1),
                $this->color,
                $this->width
            )
        ;

        return $image;
    }
}
