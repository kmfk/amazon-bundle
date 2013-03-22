<?php

/**
 * A symfony command to run Amazon SDK Commands
 *
 * Note that this currently only supports v1 of the PHP SDK.
 *
 * @author John Pancoast
 * @date 2013-03-20
 */

namespace Uecode\Bundle\AmazonBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

// Amazon Classes
use \AmazonSWF;
use \CFRuntime;

class AWSSDKCommand extends Command
{
    protected $name = "poll:ue:workflow:uePoc";
    protected function configure() {
        $this
            ->setName('ue:workflow:start')
            ->setDescription('Send a start workflow execution to amazon.')
            ->addOption(
                'key',
                null,
                InputOption::VALUE_REQUIRED,
                'The amazon AWS key used for authentication'
            )
            ->addOption(
                'secret',
                null,
                InputOption::VALUE_REQUIRED,
                'The amazon AWS secret used for authentication'
            )
            ->addOption(
                'sdk_command',
                null,
                InputOption::VALUE_REQUIRED,
                'The amazon SDK command (v1 of SDK)'
            )
            ->addOption(
                'options',
                null,
                InputOption::VALUE_REQUIRED,
                'The amazon SWF options (as JSON object)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $key = $input->getOption('key');
        $secret = $input->getOption('secret');
        $command = $input->getOption('sdk_command');
        $options = $input->getOption('options');

        $swf = new AmazonSWF(array('key' => $key, 'secret' => $secret));

        if (!method_exists($swf, $command)) {
            throw new \Exception('Amazon SWF/SDK method "'.$command.'" does not exist');
        }

        $options = json_decode($options, true);
        $result = $swf->{$command}($options);
        $output->writeln($result->body);
    }
}