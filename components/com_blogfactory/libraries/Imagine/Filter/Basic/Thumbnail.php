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
use Imagine\Image\BoxInterface;
use Imagine\Filter\FilterInterface;

/**
 * A thumbnail filter
 */
class Thumbnail implements FilterInterface
{
    /**
     * @var BoxInterface
     */
    private $size;

    /**
     * @var string
     */
    private $mode;

    /**
     * Constructs the Thumbnail filter with given width, height and mode
     *
     * @param BoxInterface $size
     * @param string       $mode
     */
    public function __construct(BoxInterface $size, $mode = ImageInterface::THUMBNAIL_INSET)
    {
        $this->size = $size;
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return $image->thumbnail($this->size, $this->mode);
    }
}
