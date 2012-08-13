<?php
use yami\Http\Request;

use yamiSample\Filter;

$host = Request::getInstance()->HTTP_HOST;
switch($host) {
	case 'red.yami-sample.local':
		$cont->addFilter(new Filter('red'));
		break;

	case 'white.yami-sample.local':
		$cont->addFilter(new Filter('white'));
		break;
}