/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

 CKEDITOR.stylesSet.add( 'nbrazil', [

    { name: 'Parágrafo', element: 'p' },
    { name: 'Título 1', element: 'h1' },
    { name: 'Título 2', element: 'h2' },
    { name: 'Título 3', element: 'h3' },
    { name: 'Título 4', element: 'h4' },
    { name: 'Título 5', element: 'h5' }

]);


CKEDITOR.editorConfig = function( config ) {
	
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
	config.plugins = 'dialogui,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,div,resize,toolbar,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo,font,forms,format,horizontalrule,htmlwriter,iframe,wysiwygarea,image,indent,indentblock,indentlist,smiley,justify,link,list,liststyle,magicline,maximize,newpage,pagebreak,pastetext,pastefromword,preview,print,removeformat,save,selectall,showblocks,showborders,sourcearea,specialchar,menubutton,scayt,stylescombo,tab,table,tabletools,undo,wsc';
	config.skin = 'moonocolor';
	// %REMOVE_END%

	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';


	config.toolbar = [
    ['Cut','Copy','Paste','PasteText','PasteFromWord', '-', 'Undo', 'Redo' , '-', 'Scayt'],
    
  	//['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
  	['Image', 'Youtube'],
  	['Maximize', 'ShowBlocks'],
  	['Styles'],
  	['Source'],
  	
  	
    ['Bold','Italic','Underline','Strike','Subscript', 'Superscript', '-', 'RemoveFormat'], 
    
  	['Print', 'SpellChecker', 'Scayt'],
      ['NumberedList','BulletedList', 'Blockquote', '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
  	['Link','Unlink','Anchor']
  ],
  
  config.extraPlugins = 'youtube',
  
  // For inline style definition.
  config.stylesSet = 'nbrazil';
};



