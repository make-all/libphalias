<?php
/**
 * Diffusion: Lookup User event listener for looking up a user in an
 * svn aliases file.
 *
 * Copyright 2014 The Maker
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
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
