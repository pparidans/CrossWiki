<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

/**
 * CONFIGURATION
 */
$wgCrossWikiUrl = "";
$wgCrossWikiUsername = "";
$wgCrossWikiPassword = "";

/**
 * REGISTRATION
 */
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'CrossWiki',
	'version' => '0.0.1',
	'url' => 'http://www.arag.be',
	'author' => array( 'Pierre Paridans' ),
);

$wgAutoloadClasses['ExtCrossWiki'] = __DIR__ . '/CrossWiki.body.php';

// Specify the function that will initialize the parser function.
$wgHooks['ParserFirstCallInit'][] = 'CrossWikiSetupParserFunction';

// Allow translation of the parser function name
$wgExtensionMessagesFiles['CrossWikiMagic'] = __DIR__ . '/CrossWiki.i18n.magic.php';

// Tell MediaWiki that the parser function exists.
function CrossWikiSetupParserFunction( &$parser ) {

   // Create a function hook associating the "example" magic word with the
   // ExampleExtensionRenderParserFunction() function. See: the section
   // 'setFunctionHook' below for details.
   $parser->setFunctionHook( 'get_content', 'ExtCrossWiki::get_content' );

   // Return true so that MediaWiki continues to load extensions.
   return true;
}
