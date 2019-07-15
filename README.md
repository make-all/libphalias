libphalias
==========

This extension to [Phabricator](http://phabricator.org/) looks up user names
in the svn aliases file, in order to map them to phabricator users.

This can be useful if you've already moved users over to a new authentication
backend, and want to maintain links between users on both svn and phabricator.

NOTE: There is currently work underway to let users specify their own aliases in 
the Phabricator settings, see https://secure.phabricator.com/T12164 
This extension may be obsoleted by that work.

Installation
------------

To install this library, simply clone this repository alongside your phabricator
installation:

    cd /path/to/install
	git clone https://github.com/make-all/libphalias.git

Then simply add the path to this library to your phabricator configuration:

	cd /path/to/install/phabricator
	./bin/config set load-libraries '["libphalias"]'
	./bin/config set events.listeners '["DiffusionLookupUserAlias"]'

This extension could also be used to read other alias files, as long as they
have a similar format to the svn aliases file, which can be parsed by PHP's
`parse_ini_file($filename)` function.  It should also be quite simple to
change the parser to handle other formats.
