<?php namespace Phpdpkg\Tool;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

use Phpdpkg\PhpdpkgCommand;
use Phpdpkg\Helper\ConfigurationHelper;

class PhpdpkgApplication extends Application {

  /**
   * Gets the name of the command based on input.
   *
   * @param InputInterface $input The input interface
   *
   * @return string The command name
   */
  protected function getCommandName(InputInterface $input) {
    // This should return the name of your command.
    return 'build';
  }

  /**
   * Gets the default commands that should always be available.
   *
   * @return array An array of default Command instances
   */
  protected function getDefaultCommands() {
    // Keep the core default commands to have the HelpCommand
    // which is used when using the --help option
    $defaultCommands = parent::getDefaultCommands();

    $defaultCommands[] = new PhpdpkgCommand();

    return $defaultCommands;
  }

  /**
   * Overridden so that the application doesn't expect the command
   * name to be the first argument.
   */
  public function getDefinition() {
    $inputDefinition = parent::getDefinition();
    // clear out the normal first argument, which is the command name
    $inputDefinition->setArguments();

    return $inputDefinition;
  }

  /**
   * @override
   */
  protected function getDefaultHelperSet() {
    $helperSet = parent::getDefaultHelperSet();
    $helperSet->set(new ConfigurationHelper());

    return $helperSet;
  }

}
