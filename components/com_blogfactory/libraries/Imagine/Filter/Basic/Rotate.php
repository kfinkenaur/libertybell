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

namespace Imagine\Filter\Basic;

defined('_JEXEC') or die;

use Imagine\Image\ImageInterface;
use Imagine\Image\Color;
use Imagine\Filter\FilterInterface;

/**
 * A rotate filter
 */
class Rotate implements FilterInterface
{
    /**
     * @var integer
     */
    private $angle;

    /**
     * @var Color
     */
    private $background;

    /**
     * Constructs Rotate filter with given angle and background color
     *
     * @param integer $angle
     * @param Color   $background
     */
    public function __construct($angle, Color $background = null)
    {
        $this->angle      = $angle;
        $this->background = $background;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return $image->rotate($this->angle, $this->background);
    }
}
