<?php namespace Phpdpkg;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PhpdpkgCommand extends Command {

  protected function configure() {
    $this
      ->setName('make')
      ->setDescription('Make a debian package')
      ->addArgument(
        'name',
        InputArgument::OPTIONAL,
        'The name of the package to create'
      )
      ->addOption(
        'yell',
        null,
        InputOption::VALUE_NONE,
        'If set, the task will yell in uppercase letters'
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $name = $input->getArgument('name');
    if ($name) {
      $text = 'Hello '.$name;
    }
    else {
      $text = 'Hello';
    }

    if ($input->getOption('yell')) {
      $text = strtoupper($text);
    }

    $output->writeln($text);
  }

}
