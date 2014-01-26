$('form').parsley( {
    successClass: 'has-success', 
    errorClass: 'has-error',
    errors: {
        container: function (element, isCheckbox) {
            if (isCheckbox) {
                var $container = element.parent().find(".parsley-container");
                if ($container.length === 0) {
                    $container = $("<div class='parsley-container'></div>").insertAfter(element.parent('label:last-child'));
                }
                return $container;
            }
        },
        classHandler: function (elem) {
            return $(elem).parent();
        }
    }
} );

   $(function () {
        $('textarea[data-editor]').each(function () {
            var textarea = $(this);
 
            var mode = textarea.data('editor');
 
            var editDiv = $('<div>', {
                position: 'absolute',
                width: '100%',
                height: '600px',
                'class': textarea.attr('class')
            }).insertBefore(textarea);
 
            textarea.css('visibility', 'hidden');
 
            var editor = ace.edit(editDiv[0]);
            //editor.renderer.setShowGutter(false);
            editor.setPrintMarginColumn(-1);
            editor.getSession().setValue(textarea.val());
            editor.getSession().setMode("ace/mode/" + mode);
            editor.setTheme("ace/theme/dreamweaver");

            // copy back to textarea on form submit...
            textarea.closest('form').keyup(function () {
                textarea.val(editor.getSession().getValue());
            })
 
        });
    });