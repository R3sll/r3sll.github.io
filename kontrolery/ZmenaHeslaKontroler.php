<?php

// Controller pro zpracování článku

class ZmenaHeslaKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'editor';

		$zmenaHesla = new ZmenaHesla();

		if ($_POST) {
			if ($_POST['heslo'] == $_POST['heslo_znovu']) {
				$uzivatelIfno = $zmenaHesla->vratUzivateleAsi($_POST['jmeno']);

				if ($uzivatelIfno) {

					if (password_verify($_POST['puvodniheslo'], $uzivatelIfno['heslo'])) {
						$zmenaHesla->zmenUzivateleAsi($_POST['jmeno'], $_POST['heslo']);
						$this->pridejZpravu('Heslo úspěšně změněno.');
					} else {
						$this->pridejZpravu('Původní heslo neodpovídá.');
					}
				} else {
					$this->pridejZpravu('Uživatel neexistuje.');
				}
			} else {
				$this->pridejZpravu('Hesla se neshodují.');
			}
		}

		// Nastavení šablony
		$this->pohled = 'zmenaHesla';
	}
}
