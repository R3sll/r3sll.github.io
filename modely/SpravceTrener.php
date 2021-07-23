<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceTrener
{

	// Vrátí článek z databáze podle jeho URL
	public function vratTrenera($url)
	{
		return Db::dotazJeden('
		SELECT *
		FROM treneri AS rk
		LEFT JOIN clenove AS rt ON rk.id_trenera = rt.id_realizacni_tym
		LEFT JOIN kategorie AS k ON rk.id_kategorie = k.id_kategorie
		WHERE url = ?
		', array($url));
	}

	public function vratSeznamTreneru($url)
	{
		return Db::dotazVsechny('
		SELECT *
		FROM treneri AS rk
		LEFT JOIN clenove AS rt ON rk.id_trenera = rt.id_realizacni_tym
		LEFT JOIN kategorie AS k ON rk.id_kategorie = k.id_kategorie
		WHERE url = ?
		', array($url));
	}

	public function vratJedenTrener()
	{
		return Db::dotazJeden('
		SELECT *
		FROM treneri AS rk
		LEFT JOIN clenove AS rt ON rk.id_trenera = rt.id_realizacni_tym
		LEFT JOIN kategorie AS k ON rk.id_kategorie = k.id_kategorie
		WHERE id_realizacni_tym = ?
		');
	}

	public function vratTrenery()
	{
		return Db::dotazVsechny('
		SELECT *
		FROM treneri AS rk
		LEFT JOIN clenove AS rt ON rk.id_trenera = rt.id_realizacni_tym
		LEFT JOIN kategorie AS k ON rk.id_kategorie = k.id_kategorie
		');
	}

	public function vratPagTreneru($strana, $naStranu)
	{
		return Db::dotazVsechny('SELECT *
		FROM treneri AS rk
		LEFT JOIN clenove AS rt ON rk.id_trenera = rt.id_realizacni_tym
		LEFT JOIN kategorie AS k ON rk.id_kategorie = k.id_kategorie
		ORDER BY prijmeni LIMIT ?, ?', array(($strana - 1) * $naStranu,$naStranu)
		);
	}
	public function vratPocetTreneru()
	{
		return Db::dotazJeden('SELECT COUNT(*) AS cnt FROM treneri');
	}
	// ----------------------------------------------------------------------

	public function ulozTrenera($trener, $kategorie)
	{

		Db::dotaz('INSERT INTO treneri (id_trenera, id_kategorie) value (? , ?)', array($trener, $kategorie));
	}

	public function odstranTrenera($trener)
	{
		Db::dotaz('DELETE FROM treneri WHERE id_trenera = ?', array($trener));
	}

	public function vratEditTrenera($url)
	{
		return Db::dotazJeden('
		SELECT *
		FROM treneri AS rk
		LEFT JOIN clenove AS rt ON rk.id_trenera = rt.id_realizacni_tym
		LEFT JOIN kategorie AS k ON rk.id_kategorie = k.id_kategorie
		WHERE id_realizacni_tym = ?
		', array($url));
	}
}
