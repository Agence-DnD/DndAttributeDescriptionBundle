<?php

namespace Dnd\Bundle\AttributeDescriptionBundle\ArrayConverter\StandardToFlat;

use Pim\Component\Connector\ArrayConverter\StandardToFlat\Attribute as BaseAttribute;

/**
 * @override: Handle localizable attribute description in standard array to flat array conversion
 *
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
     * {@inheritdoc}
     */
    protected function convertProperty($property, $data, array $convertedItem, array $options)
    {
        switch ($property) {
            case 'labels':
                foreach ($data as $localeCode => $label) {
                    $labelKey                 = sprintf('label-%s', $localeCode);
                    $convertedItem[$labelKey] = $label;
                }
                break;
            // Add @DND
            case 'descriptions':
                foreach ($data as $localeCode => $description) {
                    $descriptionKey                 = sprintf('description-%s', $localeCode);
                    $convertedItem[$descriptionKey] = $description; // convert all localizable values of  attribute description field
                }
                break;
            // / Add @DND
            case 'options':
            case 'available_locales':
            case 'allowed_extensions':
                $convertedItem[$property] = implode(',', $data);
                break;
            case in_array($property, $this->booleanFields):
                if (null === $data) {
                    $convertedItem[$property] = '';
                    break;
                }

                $convertedItem[$property] = (true === $data) ? '1' : '0';
                break;
            default:
                $convertedItem[$property] = (string)$data;
        }

        return $convertedItem;
    }
}
