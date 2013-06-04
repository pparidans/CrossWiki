<?php

require __DIR__ . '/vendor/autoload.php';

use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

class ExtCrossWiki {

	public static function get_content($parser, $page_title = ''){
		global $wgCrossWikiSettings;
		$page_title = trim($page_title);
		$login_url = $wgCrossWikiSettings['url'] . "/api.php";
		$login_vars = array(
			'action' => "login",
			'lgname' => $wgCrossWikiSettings['username'],
			'lgpassword' => $wgCrossWikiSettings['password'],
			'lgdomain' => $wgCrossWikiSettings['domain'],
			'format' => "php",
		);

		$cookiePlugin = new CookiePlugin(new ArrayCookieJar());
		$client = new Client();
		$client->addSubscriber($cookiePlugin);

		$login_request = $client->post($login_url, null, $login_vars);
		$response = unserialize($login_request->send()->getBody());
		$login_vars['lgtoken'] = $response['login']['token'];
		$login_request = $client->post($login_url, null, $login_vars);
		$login_request->send();

		$url =  $wgCrossWikiSettings['url'] . "/api.php?format=xml&action=query&titles=$page_title&prop=revisions&rvprop=content";
		$request = $client->get($url);

		$response = $request->send();

		$xml = $response->xml();
		$output = $xml->query->pages->page->revisions->rev;

		return $output;
	}

}
