<?php

class SpravceFunkcionaru
{

	public function vratFunkcionare()
	{
		return Db::dotazJeden('
		SELECT *
		FROM funkcionari AS rk
		LEFT JOIN clenove AS rt ON rk.id_clena = rt.id_realizacni_tym
		WHERE id_realizacni_tym = ?
		');
	}

	public function vratSeznamFunkcionaru()
	{

		return Db::dotazVsechny('
		SELECT * 
		FROM funkcionari AS rk
		LEFT JOIN clenove AS rt ON rk.id_clena = rt.id_realizacni_tym		
		');
	}

	public function ulozFunkcionare($funkcionar, $pozice)
	{
		Db::dotaz('DELETE FROM funkcionari WHERE id_clena = ?', array($funkcionar));

		Db::dotaz('INSERT INTO funkcionari (id_clena, pozice) value (? , ?)', array($funkcionar, $pozice));
	}

	public function odstranFunkcionare($funkcionar)
	{
		Db::dotaz('DELETE FROM funkcionari WHERE id_clena = ? ', array($funkcionar));
	}

	public function vratEditFunkcionare($url)
	{

		return Db::dotazJeden('
		SELECT *
		FROM funkcionari AS rk
		LEFT JOIN clenove AS rt ON rk.id_clena = rt.id_realizacni_tym
		WHERE id_realizacni_tym = ?
		', array($url));
	}
}
