/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for a single toolbar row.
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'forms' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' },
		{ name: 'about' }
	];

	// The default plugins included in the basic setup define some buttons that
	// are not needed in a basic editor. They are removed here.
	config.removeButtons = 'Anchor,Subscript,Superscript,About,Table,HorizontalRule,Maximize';
	config.removePlugins = 'Maximize';

	// Dialog windows are also simplified.
	config.removeDialogTabs = 'link:advanced;link:upload;image:upload';
	
	config.extraPlugins = 'wysiwygarea,notification,blockquote,colorbutton,panelbutton,find,removeformat,selectall,a11yhelp,image,uploadimage,widget,uploadwidget,filetools,notificationaggregator,lineutils,embed,embedbase,justify';
	config.toolbarCanCollapse = true;
	config.filebrowserImageBrowseUrl = 'https://' + window.location.host + '/includes/console/scripts/ddcfinder/index.php'
};
