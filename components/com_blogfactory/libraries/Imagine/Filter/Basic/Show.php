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
use Imagine\Filter\FilterInterface;

/**
 * A show filter
 */
class Show implements FilterInterface
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructs the Show filter with given format and options
     *
     * @param string $format
     * @param array  $options
     */
    public function __construct($format, array $options = array())
    {
        $this->format  = $format;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return $image->show($this->format, $this->options);
    }
}
