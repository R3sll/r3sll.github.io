<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceVysledku
{

	// Vrátí článek z databáze podle jeho URL
	public function vratVysledek($url)
	{
		return Db::dotazJeden('
        	SELECT d.nazev_tymu AS domaci, h.nazev_tymu AS hoste, id_zapasu, nazev_kategorie, caskonani, domaci_vysledek, hoste_vysledek, url FROM vysledky_zapasu AS vz 
        	JOIN kategorie ON kategorie_id = id_kategorie
        	JOIN tymy AS d on vz.domaci = d.id_tymy 
        	JOIN tymy AS h on vz.hoste = h.id_tymy
        	WHERE url = ?
		', array($url));
	}

	public function vratSeznamVysledku($url)
	{
		return Db::dotazVsechny('
			SELECT d.nazev_tymu AS domaci, h.nazev_tymu AS hoste, id_zapasu, nazev_kategorie, caskonani, domaci_vysledek, hoste_vysledek, url FROM vysledky_zapasu AS vz 
        	JOIN kategorie ON kategorie_id = id_kategorie
        	JOIN tymy AS d on vz.domaci = d.id_tymy 
        	JOIN tymy AS h on vz.hoste = h.id_tymy
        	WHERE url = ?
			ORDER BY caskonani
		', array($url));
	}

	public function vratEditVysledek($url)
	{
		return Db::dotazJeden('
        	SELECT d.nazev_tymu AS nazevdomaci, h.nazev_tymu AS nazevhoste, domaci, hoste, id_zapasu, nazev_kategorie, caskonani, domaci_vysledek, hoste_vysledek, url, kategorie_id FROM vysledky_zapasu AS vz 
        	JOIN kategorie ON kategorie_id = id_kategorie
        	JOIN tymy AS d on vz.domaci = d.id_tymy 
        	JOIN tymy AS h on vz.hoste = h.id_tymy
        	WHERE id_zapasu = ?
		', array($url));
	}

	public function ulozVysledek($id, $vysledek)
	{
		if (!$id)
			Db::vloz('vysledky_zapasu', $vysledek);
		else
			Db::zmen('vysledky_zapasu', $vysledek, 'WHERE id_zapasu = ?', array($id));
	}

	public function odstranVysledek($id)
	{
		Db::dotaz('
			DELETE FROM vysledky_zapasu
			WHERE id_zapasu = ?
		', array($id));
	}
}
