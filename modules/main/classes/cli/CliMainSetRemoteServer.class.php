<?php

	/**
	 * CLI command class, main -> set_remote
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 * @version 2.0
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package thebuggenie
	 * @subpackage core
	 */

	/**
	 * CLI command class, main -> set_remote
	 *
	 * @package thebuggenie
	 * @subpackage core
	 */
	class CliMainSetRemoteServer extends TBGCliCommand
	{

		protected function _setup()
		{
			$this->_command_name = 'set_remote';
			$this->_description = "Set a default server to connect to and / or username to connect as";
			$this->addRequiredArgument('server_url', "The URL for the remote The Bug Genie installation");
			$this->addOptionalArgument('username', "The username to connect with. If not specified, will use the current logged in user");
		}

		public function do_execute()
		{
			$this->cliEcho('Saving remote server: ');
			$this->cliEcho($this->getProvidedArgument('server_url'), 'white', 'bold');
			$this->cliEcho("\n");
			file_put_contents(TBGContext::getIncludePath() . '.remote_server', $this->getProvidedArgument('server_url'));
			if ($this->hasProvidedArgument('username'))
			{
				$this->cliEcho('Saving remote username: ');
				$this->cliEcho($this->getProvidedArgument('username'), 'white', 'bold');
				$this->cliEcho("\n");
				file_put_contents(TBGContext::getIncludePath() . '.remote_username', $this->getProvidedArgument('username'));
				$this->cliEcho("\n");
				$this->cliEcho('To avoid being asked for a password, please enter the password for the remote user ');
				$this->cliEcho($this->getProvidedArgument('username'), 'white', 'bold');
				$this->cliEcho(" (a hash of the password will be stored).\nIf you don't want to store this, simply press enter:\n");
				$this->cliEcho("Enter the password: ", 'white', 'bold');
				$password = $this->_getCliInput();
				if ($password != '')
				{
					file_put_contents(TBGContext::getIncludePath() . '.remote_password_hash', TBGUser::hashPassword($password));
					$this->cliEcho("Password hash saved.\n", 'white', 'bold');
				}
			}
		}

	}