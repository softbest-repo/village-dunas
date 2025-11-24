CKEDITOR.dialog.add('lineheightDialog', function(editor) {
    return {
        title: 'Line Height',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'info',
                elements: [
                    {
                        type: 'text',
                        id: 'lineheight',
                        label: 'Line Height',
                        validate: CKEDITOR.dialog.validate.notEmpty("Line height field cannot be empty."),
                        setup: function(widget) {
                            this.setValue(widget.data.lineheight);
                        },
                        commit: function(widget) {
                            widget.setData('lineheight', this.getValue());
                        }
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var lineHeight = dialog.getValueOf('info', 'lineheight');
            var style = new CKEDITOR.style({ element: 'p', styles: { 'line-height': lineHeight } });
            editor.applyStyle(style);
        }
    };
});
