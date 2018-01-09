<?php

namespace Dnd\Bundle\AttributeDescriptionBundle\Entity;

use Pim\Bundle\CatalogBundle\Entity\Attribute as BaseAttribute;

/**
 * Class Attribute
 *
 * @author                 Benjamin Hil <benjamin.hil@dnd.fr>
 * @copyright              Copyright (c) 2018 Agence Dn'D
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                   http://www.dnd.fr/
 */
class Attribute extends BaseAttribute
{

    /**
     * @return null|string
     */
    public function getDescription()
    {
        $translated = ($this->getTranslation()) ? $this->getTranslation()->getDescription() : null;

        return ($translated !== '' && $translated !== null) ? $translated : '['.$this->getCode().']';
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->getTranslation()->setDescription($description);

        return $this;
    }

    /**
     * @return string
     */
    public function getTranslationFQCN()
    {
        return AttributeTranslation::class;
    }
}
