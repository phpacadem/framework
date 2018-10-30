<?php

namespace PhpAcadem\framework\container;


use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

class ContainerBuilder extends \DI\ContainerBuilder
{

    protected $configDir;
    protected $paramsDefinitionDir;
    protected $servicesDefinitionDir;

    public function __construct(string $containerClass = 'DI\Container')
    {
        parent::__construct($containerClass);
        $this->addDefinitions(__DIR__ . '/../services.php');


        $this->useAnnotations(false);
    }

    public function build()
    {
        $this->loadConfigDefinitions();

        return parent::build();
    }


    /**
     * @param mixed $configDir
     */
    public function setConfigDir($configDir): void
    {
        $this->configDir = $configDir;
    }

    protected function loadConfigDefinitions()
    {

        if ($this->configDir && is_dir($this->configDir)) {

            if (file_exists($this->configDir . '/params/params.php')) {
                $params = require $this->configDir . '/params/params.php';
            } else if (file_exists($this->configDir . '/params/params.php.dist')) {
                $params = require $this->configDir . '/params/params.php.dist';
            }

            $this->addDefinitions($params);

            // begin this is for production
            if (!empty($params['diCacheProxyDir'])) {
                $this->writeProxiesToFile(true, $params['diCacheProxyDir']);
            }
            if (!empty($params['diCacheCompilationDir'])) {
                $this->enableCompilation($params['diCacheCompilationDir']);
            }
            // end this is for production
        }

        if ($this->configDir && is_dir($this->configDir)) {

            $configs = [];

            if (file_exists($this->configDir . '/di/services.php')) {
                $configs[] = new PhpFileProvider($this->configDir . '/di/services.php');
            }

            if (file_exists($this->configDir . '/di/components.php')) {
                $components = require $this->configDir . '/di/components.php';
                /** @var \Interop\Container\ServiceProviderInterface $component */
                foreach ($components as $component) {
                    $configs[] = new ArrayProvider($component->getFactories());
                }
            }


            $aggregator = new ConfigAggregator($configs);
            $servicesDefinitions = $aggregator->getMergedConfig();

            $this->addDefinitions($servicesDefinitions);

        }
    }

}