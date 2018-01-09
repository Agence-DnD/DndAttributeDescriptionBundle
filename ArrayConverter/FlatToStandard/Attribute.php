<?php

namespace Dnd\Bundle\AttributeDescriptionBundle\ArrayConverter\FlatToStandard;

use Pim\Component\Connector\ArrayConverter\FlatToStandard\Attribute as BaseAttribute;

/**
 * @override: Handle localizable attribute description in flat array to standard array conversion
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
     *
     * Converts flat csv array to standard structured array:
     */
    public function convert(array $item, array $options = [])
    {
        $this->fieldChecker->checkFieldsPresence($item, ['code']);
        $this->fieldChecker->checkFieldsFilling($item, ['code']);

        // Add @DND
        $convertedItem = ['labels' => [], 'descriptions' => []]; // add descriptions field to convertedItem array
        // / Add @DND

        foreach ($item as $field => $data) {
            $convertedItem = $this->convertFields($field, $this->booleanFields, $data, $convertedItem);
        }

        return $convertedItem;
    }

    /**
     * @param string $field
     * @param array $booleanFields
     * @param array $data
     * @param array $convertedItem
     *
     * @return array
     */
    protected function convertFields($field, $booleanFields, $data, $convertedItem)
    {
        if (false !== strpos($field, 'label-', 0)) {
            $labelTokens                           = explode('-', $field);
            $labelLocale                           = $labelTokens[1];
            $convertedItem['labels'][$labelLocale] = $data;
        // Add @DND
        } elseif (false !== strpos($field, 'description-', 0)) {
            $descriptionTokens                                 = explode('-', $field);
            $descriptionLocale                                 = $descriptionTokens[1];
            $convertedItem['descriptions'][$descriptionLocale] = $data; // convert all localizable values of  attribute description field
        // / Add @DND
        } elseif ('number_min' === $field || 'number_max' === $field || 'max_file_size' === $field) {
            $convertedItem[$field] = $this->convertFloat($data);
        } elseif ('sort_order' === $field || 'max_characters' === $field || 'minimum_input_length' === $field) {
            $convertedItem[$field] = ('' === $data) ? null : (int)$data;
        } elseif ('options' === $field || 'available_locales' === $field || 'allowed_extensions' === $field) {
            $convertedItem[$field] = ('' === $data) ? [] : explode(',', $data);
        } elseif ('date_min' === $field || 'date_max' === $field) {
            $convertedItem[$field] = $this->convertDate($data);
        } elseif (in_array($field, $booleanFields, true) && '' !== $data) {
            $convertedItem[$field] = (bool)$data;
        } elseif ('' !== $data) {
            $convertedItem[$field] = (string)$data;
        } else {
            $convertedItem[$field] = null;
        }

        return $convertedItem;
    }
}
