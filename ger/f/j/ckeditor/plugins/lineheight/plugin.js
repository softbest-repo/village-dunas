CKEDITOR.plugins.add('lineheight', {
    requires: 'dialog',
    init: function(editor) {
        editor.addCommand('lineheight', new CKEDITOR.dialogCommand('lineheightDialog'));
        editor.ui.addButton('LineHeight', {
            label: 'Line Height',
            command: 'lineheight',
            toolbar: 'styles,1',
            icon: this.path + 'icons/lineheight.png' // Adicione o ícone do botão aqui, se desejar.
        });
        CKEDITOR.dialog.add('lineheightDialog', this.path + 'dialogs/lineheight.js');
    }
});
