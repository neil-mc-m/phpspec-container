<?php

namespace App;


class CacheProvider
{
	private $serviceProvider;

	public function __construct(ServiceProviderInterface $serviceProvider)
	{
		$this->serviceProvider = $serviceProvider;
	}
}