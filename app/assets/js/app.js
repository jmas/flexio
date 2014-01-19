$('form').parsley( {
    successClass: 'has-success', 
    errorClass: 'has-error',
    errors: {
        container: function (element, isCheckbox) {
            if (isCheckbox) {
                var $container = element.parent().find(".parsley-container");
                if ($container.length === 0) {
                    $container = $("<div class='parsley-container'></div>").insertAfter(element.parent('div:last-child'));
                }
                return $container;
            }
        },
        classHandler: function (elem) {
            return $(elem).parent();
        }
    }
} );