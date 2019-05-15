<?php
declare(strict_types=1);

namespace LoyaltyCorp\EasyCfhighlander\Console\Commands;

final class CloudFormationCommand extends AbstractTemplatesCommand
{
    /**
     * Configure command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('cloudformation');
        $this->setDescription('Generates Cfhighlander templates for CloudFormation repository.');

        parent::configure();
    }

    /**
     * Get project files names.
     *
     * @return string[]
     */
    protected function getProjectFiles(): array
    {
        return [
            'project.cfhighlander.rb',
            'project.config.yaml',
            'project.mappings.yaml'
        ];
    }

    /**
     * Get simple files names.
     *
     * @return string[]
     */
    protected function getSimpleFiles(): array
    {
        return [
            'Jenkinsfile',
            'aurora.config.yaml',
            'az.mappings.yaml',
            'bastion.config.yaml',
            'kms.config.yaml',
            'loadbalancer.config.yaml',
            'redis.config.yaml',
            'sqs.config.yaml',
            'vpc.config.yaml',
            // ECS
            'ecs/ecs.cfhighlander.rb',
            'ecs/ecs.cfndsl.rb',
            'ecs/ecs.config.yaml',
            // Redis
            'redis/redis.cfhighlander.rb',
            'redis/redis.cfndsl.rb',
            'redis/redis.config.yaml',
            'redis/redis.mappings.yaml'
        ];
    }

    /**
     * Get template prefix.
     *
     * @return string
     */
    protected function getTemplatePrefix(): string
    {
        return 'cloudformation';
    }
}
