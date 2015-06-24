/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	//lista com todos os botoes disponiveis
	//http://ckeditor.com/comment/123266#comment-123266

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'document' },
		{ name: 'clipboard'},
		{ name: 'editing'},
		{ name: 'forms' },
		{ name: 'basicstyles', groups: [ 'basicstyles'	] },
		{ name: 'insert' },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'PasteFromWord,PasteText,Paste,Maximize,Font,FontSize,Styles,Format,SpecialChar,Table,HorizontalRule,Image,ImageButton,list,links,about,indent,blocks,align,bidi,Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	config.resize_dir = 'both';
};

CKEDITOR.on( 'instanceReady', function( ev ) {
	var blockTags = ['div','h1','h2','h3','h4','h5','h6','p','pre','ul','li'];
	var rules = {
	indent : false,
		breakBeforeOpen : false,
		breakAfterOpen : false,
		breakBeforeClose : false,
		breakAfterClose : false
	};

	for (var i=0; i<blockTags.length; i++) {
		ev.editor.dataProcessor.writer.setRules( blockTags[i], rules );
	}

});