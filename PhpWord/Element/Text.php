<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2014 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace PhpOffice\PhpWord\Element;

use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Paragraph;

/**
 * Text element
 */
class Text extends AbstractElement
{
    /**
     * Text content
     *
     * @var string
     */
    protected $text;

    /**
     * Text style
     *
     * @var string|\PhpOffice\PhpWord\Style\Font
     */
    protected $fontStyle;

    /**
     * Paragraph style
     *
     * @var string|\PhpOffice\PhpWord\Style\Paragraph
     */
    protected $paragraphStyle;

    /**
     * Create a new Text Element
     *
     * @param string|null $text
     * @param mixed|null $fontStyle
     * @param mixed|null $paragraphStyle
     */
    public function __construct($text = null, $fontStyle = null, $paragraphStyle = null)
    {
        $this->setText($text);
        $this->setParagraphStyle($paragraphStyle);
        $this->setFontStyle($fontStyle);
    }

    /**
     * Set Text style
     *
     * @param string|array|\PhpOffice\PhpWord\Style\Font|null $style
     * @return string|\PhpOffice\PhpWord\Style\Font
     */
    public function setFontStyle($style = null)
    {
        if ($style instanceof Font) {
            $this->fontStyle = $style;
        } elseif (is_array($style)) {
            $this->fontStyle = new Font('text');
            $this->fontStyle->setStyleByArray($style);
        } elseif (null === $style) {
            $this->fontStyle = new Font('text');
        } else {
            $this->fontStyle = $style;
        }

        return $this->fontStyle;
    }

    /**
     * Get Text style
     *
     * @return string|\PhpOffice\PhpWord\Style\Font
     */
    public function getFontStyle()
    {
        return $this->fontStyle;
    }

    /**
     * Set Paragraph style
     *
     * @param string|array|\PhpOffice\PhpWord\Style\Paragraph|null $style
     * @return string|\PhpOffice\PhpWord\Style\Paragraph
     */
    public function setParagraphStyle($style = null)
    {
        if (is_array($style)) {
            $this->paragraphStyle = new Paragraph();
            $this->paragraphStyle->setStyleByArray($style);
        } elseif ($style instanceof Paragraph) {
            $this->paragraphStyle = $style;
        } elseif (null === $style) {
            $this->paragraphStyle = new Paragraph();
        } else {
            $this->paragraphStyle = $style;
        }

        return $this->paragraphStyle;
    }

    /**
     * Get Paragraph style
     *
     * @return string|\PhpOffice\PhpWord\Style\Paragraph
     */
    public function getParagraphStyle()
    {
        return $this->paragraphStyle;
    }

    /**
     * Set text content
     *
     * @param string $text
     * @return self
     */
    public function setText($text)
    {
        $this->text = mb_convert_encoding($text, 'UTF-8');

        return $this;
    }

    /**
     * Get Text content
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
