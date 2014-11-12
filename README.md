libphalias
==========

This extension to [Phabricator](http://phabricator.org/) looks up user names
in the svn aliases file, in order to map them to phabricator users.

This can be useful if you've already moved users over to a new authentication
backend, and want to maintain links between users on both svn and phabricator.

Installation
------------

To install this library, simply clone this repository alongside your phabricator
installation:

    cd /path/to/install
	git clone https://github.com/make-all/libphalias.git

Then simply add the path to this library to your phabricator configuration:

	cd /path/to/install/phabricator
	./bin/config set load-libraries '["libphalias/src"]'
	./bin/config set event.listeners '["DiffusionLookupUserAlias"]'

This extension could also be used to read other alias files, as long as they
have a similar format to the svn aliases file, which can be parsed by PHP's
`parse_ini_file($filename)` function.  It should also be quite simple to
change the parser to handle other formats.
