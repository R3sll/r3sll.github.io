<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceClanku
{

	// Vrátí článek z databáze podle jeho URL
	public function vratClanek($url)
	{
		return Db::dotazJeden('
			SELECT *
			FROM clanek AS c
			JOIN fotografie AS f ON f.id_fotografie = c.uvodnifotka
			WHERE url = ?
		', array($url));
	}

	// Vrátí seznam článků v databázi
	public function vratClanky()
	{
		return Db::dotazVsechny('
			SELECT *
			FROM clanek AS c
			JOIN fotografie AS f ON f.id_fotografie = c.uvodnifotka
			ORDER BY datum DESC
		');
	}

	public function vratNejnovejsiClanky()
	{

		return Db::dotazVsechny('
			SELECT *
			FROM clanek  AS c
			JOIN fotografie AS f ON f.id_fotografie = c.uvodnifotka
			ORDER BY datum DESC LIMIT 3
		');
	}

	public function vratPagClanky($strana, $naStranu)
	{
		return Db::dotazVsechny('SELECT *
		FROM clanek AS c
		JOIN fotografie AS f ON f.id_fotografie = c.uvodnifotka
		ORDER BY datum DESC LIMIT ?, ?', array(($strana - 1) * $naStranu,$naStranu)
		);
	}
	public function vratPocetClanku()
	{
		return Db::dotazJeden('SELECT COUNT(*) AS cnt FROM clanek');
	}

	// ulozi clanek do systemu. Pokud je ID false, vlozi novy, jinak provede editaci
	public function ulozClanek($id, $clanek)
	{
		if (!$id)
			Db::vloz('clanek', $clanek);
		else
			Db::zmen('clanek', $clanek, 'WHERE id_clanek = ?', array($id));
	}

	// odstrani clanek
	public function odstranClanek($url)
	{
		Db::dotaz('
			DELETE FROM clanek
			WHERE url = ?
		', array($url));
	}

	public function vlozClanek($id, $nazev, $datum, $url, $popisek, $text)
	{

		Db::dotaz('DELETE FROM clanek WHERE id_clanek = ?', array($id));
			

		$clanek = Db::dotazJeden('
			SELECT * 
			FROM clanek
			WHERE url = ?
			', array($url));

		$fotka = Db::dotazJeden('SELECT MAX(id_fotografie) as id from fotografie');
	
		$clanek = array(
			'nazev_clanku' => $nazev,
			'text_clanku' => $text,
			'uvodnifotka' => $fotka['id'],
			'alba_id' => 3,
			'datum' => $datum,
			'url' => $url,
			'popisek' => $popisek,
		);

		try {
			Db::vloz('clanek', $clanek);
		} catch (PDOException $chyba) {
			throw new ChybaUzivatele($chyba->getMessage());
		}
	}
}
