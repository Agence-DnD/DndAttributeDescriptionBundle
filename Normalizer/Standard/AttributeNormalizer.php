<?php

namespace Dnd\Bundle\AttributeDescriptionBundle\Normalizer\Standard;

use Pim\Component\Catalog\Normalizer\Standard\AttributeNormalizer as BaseAttributeNormalizer;

/**
 * @override : Handle localizable attribute description in normalizer
 *
 * Class AttributeNormalizer
 *
 * @author                 Benjamin Hil <benjamin.hil@dnd.fr>
 * @copyright              Copyright (c) 2018 Agence Dn'D
 * @license                http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                   http://www.dnd.fr/
 */
class AttributeNormalizer extends BaseAttributeNormalizer
{

    /**
     * @param \Pim\Component\Catalog\Model\AttributeInterface $attribute
     * @param null $format
     * @param array $context
     *
     * @return array
     */
    public function normalize($attribute, $format = null, array $context = [])
    {
        return [
            'code'                   => $attribute->getCode(),
            'type'                   => $attribute->getType(),
            'group'                  => ($attribute->getGroup()) ? $attribute->getGroup()->getCode() : null,
            'unique'                 => (bool)$attribute->isUnique(),
            'useable_as_grid_filter' => (bool)$attribute->isUseableAsGridFilter(),
            'allowed_extensions'     => $attribute->getAllowedExtensions(),
            'metric_family'          => '' === $attribute->getMetricFamily() ? null : $attribute->getMetricFamily(),
            'default_metric_unit'    => '' === $attribute->getDefaultMetricUnit(
            ) ? null : $attribute->getDefaultMetricUnit(),
            'reference_data_name'    => $attribute->getReferenceDataName(),
            'available_locales'      => $attribute->getAvailableLocaleCodes(),
            'max_characters'         => null === $attribute->getMaxCharacters(
            ) ? null : (int)$attribute->getMaxCharacters(),
            'validation_rule'        => '' === $attribute->getValidationRule() ? null : $attribute->getValidationRule(),
            'validation_regexp'      => '' === $attribute->getValidationRegexp(
            ) ? null : $attribute->getValidationRegexp(),
            'wysiwyg_enabled'        => $attribute->isWysiwygEnabled(),
            'number_min'             => null === $attribute->getNumberMin() ? null : (string)$attribute->getNumberMin(),
            'number_max'             => null === $attribute->getNumberMax() ? null : (string)$attribute->getNumberMax(),
            'decimals_allowed'       => $attribute->isDecimalsAllowed(),
            'negative_allowed'       => $attribute->isNegativeAllowed(),
            'date_min'               => $this->dateTimeNormalizer->normalize($attribute->getDateMin()),
            'date_max'               => $this->dateTimeNormalizer->normalize($attribute->getDateMax()),
            'max_file_size'          => null === $attribute->getMaxFileSize(
            ) ? null : (string)$attribute->getMaxFileSize(),
            'minimum_input_length'   => null === $attribute->getMinimumInputLength(
            ) ? null : (int)$attribute->getMinimumInputLength(),
            'sort_order'             => (int)$attribute->getSortOrder(),
            'localizable'            => (bool)$attribute->isLocalizable(),
            'scopable'               => (bool)$attribute->isScopable(),
            'labels'                 => $this->translationNormalizer->normalize($attribute, $format, $context),
            // Add @DND
            'descriptions'           => $this->translationNormalizer->normalizeDescription($attribute, $context), // normalize localizable attribute description
            // / Add @DND
            'auto_option_sorting'    => $attribute->getProperty('auto_option_sorting'),
        ];
    }
}
