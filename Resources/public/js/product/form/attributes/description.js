'use strict';

/**
 * Module used to display the description properties of an attribute on the product grid
 */
define(
    [
        'jquery',
        'underscore',
        'pim/form'
    ],
    function ($, _, BaseForm) {
        return BaseForm.extend({
            configure: function () {
                this.listenTo(this.getRoot(), 'pim_enrich:form:field:extension:add', this.addFieldExtension);

                return BaseForm.prototype.configure.apply(this, arguments);
            },
            addFieldExtension: function (event) {
                event.promises.push($.Deferred().resolve().then(function () {
                    var field = event.field;
                    var context = event.field.context.locale;
                    if (!_.isNull(field.attribute.descriptions[context]) && !_.isEmpty(field.attribute.descriptions[context])) {
                    field.addElement(
                        'footer',
                        'descritption',
                        '<span>' + field.attribute.descriptions[context] + '</span>'
                    );
                }

                }.bind(this)).promise());

                return this;
            }
        });
    }
);