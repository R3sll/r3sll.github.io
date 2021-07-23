<?php

// Třída poskytuje metody pro správu hráčů
class SpravceClenu
{


	public function vratClena($url)
	{
		return Db::dotazJeden('
			SELECT *  FROM clenove
			WHERE id_realizacni_tym = ?
		', array($url));
	}


	public function vratSeznamClenu()
	{
		return Db::dotazVsechny('
		SELECT *  FROM clenove ORDER BY prijmeni
		');
	}

	public function vratPagClenu($strana, $naStranu)
	{
		return Db::dotazVsechny('
		SELECT *  FROM clenove 
		ORDER BY prijmeni LIMIT ?, ?', array(($strana - 1) * $naStranu,$naStranu)
		);
	}
	public function vratPocetClenu()
	{
		return Db::dotazJeden('SELECT COUNT(*) AS cnt FROM clenove');
	}



	public function ulozClena($id, $clen)
	{
		if (!$id)
			Db::vloz('clenove', $clen);
		else
			Db::zmen('clenove', $clen, 'WHERE id_realizacni_tym = ?', array($id));
	}

	public function odstranClena($clen)
	{
		Db::dotaz('
			DELETE FROM clenove
			where id_realizacni_tym = ?
		', array($clen));
	}

	public function vratEditClena($clen)
	{
		return Db::dotazJeden('
			SELECT *  FROM clenove
			WHERE id_realizacni_tym = ?
		', array($clen));
	}
}
