# phpdpkg

Create Debian packages using php bundled in a handy PHAR.

Currently this is a proof of concept to test on our build process. Handy if you're running your build process, and are running other Phar's before (PHPUNIT, PHPCS, etc) and want to have another one to generate a *.deb rather than having to use JDEB or something else in Java. Needs a lot of work to clean everything up and error check, tests, etc.

### TODO

 - Move config mangement to its own class. Check and set default values.
 - Add more filters for copying of files and folders
 - More options for versioning
 - Fill out README with setup instructions
 - Write tests
