<?php

// Controller pro zpracování článku

class AdministraceKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Do administrace mají přístup jen přihlášení uživatelé
		$this->overUzivatele();

		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'Přihlášení';
		// Získání dat o přihlášeném uživateli
		$spravceUzivatelu = new SpravceUzivatelu();
		if (!empty($parametry[0]) && $parametry[0] == 'odhlasit') {
			$spravceUzivatelu->odhlas();
			$this->presmeruj('prihlaseni');
		}
		$uzivatel = $spravceUzivatelu->vratUzivatele();
		$this->data['jmeno'] = $uzivatel['jmeno'];
		$this->data['admin'] = $uzivatel['admin'];
		// Nastavení šablony
		$this->pohled = 'administrace';
	}
}
