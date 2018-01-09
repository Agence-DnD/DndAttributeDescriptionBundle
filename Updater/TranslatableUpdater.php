<?php

namespace Dnd\Bundle\AttributeDescriptionBundle\Updater;

use Akeneo\Component\Localization\Model\AbstractTranslation;
use Akeneo\Component\Localization\Model\TranslatableInterface;
use Akeneo\Component\Localization\TranslatableUpdater as BaseTranslatableUpdater;

/**
 * @override: Handle localizable attribute description when updating a translation
 *
 * Class TranslatableUpdater
 *
 * @author                 Benjamin Hil <benjamin.hil@dnd.fr>
 * @copyright              Copyright (c) 2018 Agence Dn'D
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                   http://www.dnd.fr/
 */
class TranslatableUpdater extends BaseTranslatableUpdater
{

    /**
     * @param TranslatableInterface $object
     * @param array $data
     */
    public function update(TranslatableInterface $object, array $data)
    {
        foreach ($data as $localeCode => $label) {
            $object->setLocale($localeCode);
            $translation = $object->getTranslation();
            // Add @DND
            if (null === $label || '' === $label) {
                $translation->setLabel(null); // force label value to null instead of deleting translation
            } else {
                $translation->setLabel($label);
            }
            if (method_exists($translation, 'getDescription')) {
                $this->checkTranslationValues($object);
            }
            // / Add @DND
        }
    }

    /**
     * @param TranslatableInterface $object
     * @param array $data
     */
    public function updateDescription(TranslatableInterface $object, array $data)
    {
        // Add @DND
        foreach ($data as $localeCode => $description) { // update localizable attribute description fields
            $object->setLocale($localeCode);
            $translation = $object->getTranslation();

            if (null === $description || '' === $description) {
                $translation->setDescription(null);
            } else {
                $translation->setDescription($description);
            }

            $this->checkTranslationValues($object);
        }
        // / Add @DND
    }

    /**
     * Check the database row, then remove it if both label and description fields are null
     *
     * @param TranslatableInterface $object
     */
    public function checkTranslationValues(TranslatableInterface $object)
    {
        /** @var AbstractTranslation $translation */
        $translation = $object->getTranslation();
        /** @var string $description */
        $description = $translation->getDescription();
        /** @var string $label */
        $label       = $translation->getLabel();

        if (null === $description && null === $label) {
            $object->removeTranslation($translation);
        }
    }
}
