<?php namespace Phpdpkg;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

use Herrera\Json\Json;

class PhpdpkgCommand extends Command {

  protected $build_number;

  protected function configure() {
    $this
      ->setName('build')
      ->setDescription('Make a debian package')
      ->addArgument(
        'name',
        InputArgument::OPTIONAL,
        'The name of the package to create'
      )
      ->addOption(
        'build_number',
        0,
        InputOption::VALUE_OPTIONAL,
        'If set, the version number will have this appended as a patch in the version number'
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $output->writeln('Building package...');

    $this->build_number = $input->getOption('build_number');

    // Prepare config
    $config_file_path = realpath('phpdpkg.json');
    $json = new Json();
    $config = $json->decode(file_get_contents($config_file_path));

    // Prepare directory with files for package
    $filesystem = new Filesystem();
    $copy_directory = $config->build_directory . $config->package_base_directory;
    $filesystem->remove($copy_directory);
    $filesystem->mkdir($copy_directory, 0755);

    $files = Finder::create()
      ->files()
      ->in($config->copy_contents_of);

    foreach ($files as $file) {
      $filesystem->copy($file, $copy_directory . '/' . $file->getRelativePathname());
    }

    // Generate Debian Package file name with version
    $package_filename = implode('_', [$config->name, $config->version .'.'. $this->build_number, $config->control->architecture]) . '.deb';

    // Generate control file
    $control_file = '/DEBIAN/control';
    $text = '';
    foreach ($config->control as $key => $value) {
      $text .= ucfirst($key) .': '. $value ."\n";
    }
    $base_dir = realpath($config->build_directory);
    $filesystem->mkdir($base_dir . '/DEBIAN');
    file_put_contents($base_dir . $control_file, $text);

    $options = implode(' ', [$config->build_directory, $package_filename]);

    exec('dpkg -b '. $options);
  }

}
