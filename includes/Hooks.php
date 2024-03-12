<?php

namespace Cbx\Phpdompdf;


class Hooks
{

	public function __construct()
	{
		$this->update_checker();
	}

	public function update_checker()
	{
		$updater = new PDUpdater(CBXPHPDOMPDF_ROOT_PATH . 'cbxphpdompdf.php');
		$updater->set_username('codeboxrcodehub');
		$updater->set_repository('cbxphpdompdf');
		$updater->authorize('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');
		$updater->initialize();

		return;
	}//end method update_checker
}//end class Hooks