'use strict';

define([
        'pim/controller/attribute/create'
    ],
    function (BaseController) {
        return BaseController.extend({
            /**
             * {@inheritdoc}
             *
             * Override to add descriptions default value when creating an attribute
             */
            getNewAttribute: function (type) {
                var attribute = BaseController.prototype.getNewAttribute.apply(this, arguments);

                attribute.descriptions = {};

                return attribute;
            }
        });
    });

