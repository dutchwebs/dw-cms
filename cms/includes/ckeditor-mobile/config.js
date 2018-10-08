/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    
    CKEDITOR.config.allowedContent = true;
    
    config.filebrowserBrowseUrlClean = '/cms/includes/kcfinder/browse.php';
    config.filebrowserBrowseUrl = '/cms/includes/kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = '/cms/includes/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = '/cms/includes/kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = '/cms/includes/kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = '/cms/includes/kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = '/cms/includes/kcfinder/upload.php?opener=ckeditor&type=flash';
    
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'colors', groups: [ 'colors' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'others', groups: [ 'others' ] }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Glyphicons,Subscript,Superscript,PasteText,Paste,Copy,Cut,PasteFromWord,Anchor,RemoveFormat,Strike,about,spellchecker,btbutton,bt_table,magicline,table,tabletools';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
    
    config.sharedSpaces = {
        top: 'ToolBoxWrapper'
    };
};
