<?php

// Třída poskytuje metody pro správu hráčů
class SpravceHracu
{


	public function vratHrace($url)
	{
		return Db::dotazJeden('
			SELECT *
            FROM hraci
            JOIN kategorie ON kategorie_id = id_kategorie 
			JOIN clenove ON id_realizacni_tym = id_hraci
			WHERE url = ?
		', array($url));
	}


	public function vratSeznamHracu($url)
	{
		return Db::dotazVsechny('
		SELECT *
		FROM hraci
		JOIN kategorie ON kategorie_id = id_kategorie 
		JOIN clenove ON id_realizacni_tym = id_hraci
		WHERE url = ?
		', array($url));
	}


	public function ulozHrace($hrac, $post, $cislo_dresu, $kategorie)
	{

		Db::dotaz('DELETE FROM hraci WHERE id_hraci = ?', array($hrac));


		Db::dotaz('INSERT INTO hraci (id_hraci, post, cislo_dresu, kategorie_id) value (?, ?, ?, ?)', array($hrac, $post, $cislo_dresu, $kategorie));
	}

	public function odstranHrace($hrac)
	{
		Db::dotaz('DELETE FROM hraci WHERE id_hraci = ?', array($hrac));
	}

	public function vrateditHrace($url)
	{
		return Db::dotazJeden('
			SELECT *
			FROM hraci
			JOIN kategorie ON kategorie_id = id_kategorie 
			JOIN clenove ON id_realizacni_tym = id_hraci
			WHERE `id_hraci` = ?
		', array($url));
	}
}
