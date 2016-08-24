<?php namespace Phpdpkg;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class FileManager {

  protected $filesystem;

  public function __construct() {
    $this->filesystem = new Filesystem();
  }

  public function prepareDirectories() {


    $copy_directory = $config->build_directory . $config->package_base_directory;
    $this->filesystem->remove($copy_directory);
    $this->filesystem->mkdir($copy_directory, 0755);
  }


}