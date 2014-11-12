<?php

/**
 * Diffusion: Lookup User event listener for looking up a user in an
 * svn aliases file.
 *
 * (c) The Maker 2014
 * @group events
 */
final class DiffusionLookupUserAlias extends PhabricatorEventListener {

  const ALIAS_FILE = '/etc/subversion/aliases';
  private $aliases;

  public function register() {
    // When your listener is installed, its register() method will be called.
    // You should listen() to any events you are interested in here.

    $this->listen(PhabricatorEventType::TYPE_DIFFUSION_LOOKUPUSER);
    $this->readAliasFile();
  }

  private function readAliasFile() {
    $this->aliases = parse_ini_file(self::ALIAS_FILE);
  }

  public function handleEvent(PhutilEvent $event) {
    // When an event you have called listen() for in your register() method
    // occurs, this method will be invoked. You should respond to the event.

      $user = $event->getValue('query');

     if (isset($this->aliases[$user])) {
         // We have a mapping for this user.
	 $alias = $this->aliases[$user];

	 $matching = id(new PhabricatorUser())->loadOneWhere(
	 	   'username=%s',
		   $alias);

	 if (!empty($matching))
	    $event->setValue('result', $matching->getPHID());
      }
  }

}
