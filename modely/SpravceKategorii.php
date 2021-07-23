<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceKategorii
{

	// Vrátí článek z databáze podle jeho URL
	public function vratKategorii($url)
	{
		return Db::dotazJeden('
			SELECT *
			FROM kategorie 
			WHERE url = ?
		', array($url));
	}


	public function vratSeznamKategorii()
	{

		return Db::dotazVsechny('
			SELECT *
			FROM kategorie
			ORDER BY id_kategorie
			');
	}
}
