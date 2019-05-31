<?php
declare(strict_types=1);

namespace LoyaltyCorp\EasyDocker\Parameters;

use LoyaltyCorp\EasyDocker\Interfaces\ParameterResolverInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class ParameterResolver implements ParameterResolverInterface
{
    /** @var string */
    private $cacheFile;

    /** @var \Symfony\Component\Filesystem\Filesystem */
    private $filesystem;

    /** @var \Symplify\PackageBuilder\Parameter\ParameterProvider */
    private $parameterProvider;

    /** @var callable[] */
    private $resolvers = [];

    /**
     * ParameterResolver constructor.
     *
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     * @param \Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider
     * @param null|string $cacheFile
     */
    public function __construct(Filesystem $filesystem, ParameterProvider $parameterProvider, ?string $cacheFile = null)
    {
        $this->filesystem = $filesystem;
        $this->parameterProvider = $parameterProvider;
        $this->cacheFile = $cacheFile ?? __DIR__ . '/../../var/last_params.yaml';
    }

    /**
     * Add resolver callable.
     *
     * @param callable $resolver
     *
     * @return \LoyaltyCorp\EasyDocker\Interfaces\ParameterResolverInterface
     */
    public function addResolver(callable $resolver): ParameterResolverInterface
    {
        $this->resolvers[] = $resolver;

        return $this;
    }

    /**
     * Resolve parameters.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return mixed[]
     */
    public function resolve(InputInterface $input): array
    {
        $params = $this->resolveDefaultParameters();

        foreach ($this->resolvers as $resolver) {
            $params = \array_merge($params, \call_user_func($resolver, $params));
        }

        $params = \array_merge($params, $input->getArguments(), $input->getOptions());

        $this->filesystem->dumpFile($this->cacheFile, Yaml::dump($params));

        return $params;
    }

    /**
     * Set cache pathname to use to store previous parameters.
     *
     * @param string $pathname
     *
     * @return \LoyaltyCorp\EasyDocker\Interfaces\ParameterResolverInterface
     */
    public function setCachePathname(string $pathname): ParameterResolverInterface
    {
        $this->cacheFile = $pathname;

        return $this;
    }

    /**
     * Resolve default parameters from cache and config files.
     *
     * @return mixed[]
     */
    private function resolveDefaultParameters(): array
    {
        $params = [];

        if ($this->filesystem->exists($this->cacheFile)) {
            $params = Yaml::parseFile($this->cacheFile);
        }

        return \array_merge($params, $this->parameterProvider->provide());
    }
}