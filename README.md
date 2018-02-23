AttributeDescriptionBundle
==========================

This connector improve your workflow by adding descriptions to your attributes.

## Features

* Add/Delete/Edit a localizable description to your attribute
* Import/Export attribute description with Akeneo import/export
* The description is displayed on the product page under the attribute field

## Requirements

| AttributeDescriptionBundle   | Akeneo PIM Community Edition |
|:----------------------------:|:----------------------------:|
| v1.0.*                       | v2.*                         |

## Connector installation on Akeneo PIM

If it's not already done, install [Akeneo PIM](https://github.com/akeneo/pim-community-standard).

Get composer (with command line):
```console
$ cd /my/pim/installation/dir
$ curl -sS https://getcomposer.org/installer | php
```

Then, install DnDAttributeDescriptionBundle with composer:

In your ```composer.json```, add the following code dependending on your Akeneo PIM version:

* In `require`:

```json
{
    "agencednd/attribute-description-bundle": "1.0.*"
}
```

Next, enter the following command line:
```console
$php composer.phar require agencednd/attribute-description-bundle
```

Enable the bundle in ```app/AppKernel.php``` file, in the ```registerBundles``` function, before the line ```return $bundles```:
```php
$bundles[] = new Dnd\Bundle\AttributeDescriptionBundle\DndAttributeDescriptionBundle();
```

Then you need to override your Attribute entity in ```app/config/config.yml``` (at the end of the file):
```php
akeneo_storage_utils:
    mapping_overrides:
        -
            original: Pim\Bundle\CatalogBundle\Entity\Attribute
            override: Dnd\Bundle\AttributeDescriptionBundle\Entity\Attribute
        -
            original: Pim\Bundle\CatalogBundle\Entity\AttributeTranslation
            override: Dnd\Bundle\AttributeDescriptionBundle\Entity\AttributeTranslation
```
And enter the following command line:
```console
$php bin/console doctrine:schema:update --force
```

## Configuration

Just create/edit an attribute, a new tab has appeared and you can fill in your attribute description for each locale.

To import attribute description you need to add a new column to your classic attribute import file : description-{locale_code} (e.g: description-en_US).

## About us
Founded by lovers of innovation and design, [Agence Dn'D] (http://www.dnd.fr) assists companies in the creation and development of customized digital (open source) solutions for web and E-commerce since 2004.
