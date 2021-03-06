<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{
	public function registerBundles()
	{
		$bundles = [
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\SecurityBundle\SecurityBundle(),
			new Symfony\Bundle\TwigBundle\TwigBundle(),
			new Symfony\Bundle\MonologBundle\MonologBundle(),
			new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
			new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
			new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			new AppBundle\AppBundle(),
			## Added RS 2016-10-15
			new Misd\PhoneNumberBundle\MisdPhoneNumberBundle(),
			## Added RS 2016-10-04
			new Symfony\Bundle\AsseticBundle\AsseticBundle(),
			## Added RS 2016-10-18  https://packagist.org/packages/ancarebeca/full-calendar-bundle#v3.0.1
			new AncaRebeca\FullCalendarBundle\FullCalendarBundle(),
			## Added RS 2016-11-19 https://github.com/TheBigBrainsCompany/TbbcMoneyBundle#installation
			new Tbbc\MoneyBundle\TbbcMoneyBundle(),
			## Added RS 2017-03-18 https://github.com/suncat2000/MobileDetectBundle/blob/master/Resources/doc/index.md
			new SunCat\MobileDetectBundle\MobileDetectBundle(),

		];

		if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
			$bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
			$bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
			$bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
		}

		return $bundles;
	}

	public function getRootDir()
	{
		return __DIR__;
	}

	public function getCacheDir()
	{
		return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
	}

	public function getLogDir()
	{
		return dirname(__DIR__) . '/var/logs';
	}

	public function registerContainerConfiguration(LoaderInterface $loader)
	{
		$loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
	}
}
