<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceTymu
{

	// Vrátí článek z databáze podle jeho URL
	public function vratTym()
	{
		return Db::dotazJeden('
			SELECT id_tymy, nazev_tymu 
        	FROM tymy
			WHERE id_tymy = ?
		');
	}


	public function vratSeznamTymu()
	{
		return Db::dotazVsechny('
			SELECT id_tymy, nazev_tymu
        	FROM tymy
        	ORDER BY nazev_tymu
		');
	}

	public function vratPagTymu($strana, $naStranu)
	{
		return Db::dotazVsechny('
		SELECT id_tymy, nazev_tymu
		FROM tymy
		ORDER BY nazev_tymu LIMIT ?, ?', array(($strana - 1) * $naStranu,$naStranu)
		);
	}
	public function vratPocetTymu()
	{
		return Db::dotazJeden('SELECT COUNT(*) AS cnt FROM tymy');
	}

	public function ulozTym($id, $tym)
	{
		if (!$id)
			Db::vloz('tymy', $tym);
		else
			Db::zmen('tymy', $tym, 'WHERE id_tymy = ?', array($id));
	}

	public function odstranTym($id)
	{
		Db::dotaz('
		DELETE FROM tymy
		WHERE id_tymy = ?
		', array($id));
	}


	public function vratEditTym($url)
	{
		return Db::dotazJeden('
			SELECT id_tymy, nazev_tymu 
        	FROM tymy
			WHERE id_tymy = ?
		', array($url));
	}
}
