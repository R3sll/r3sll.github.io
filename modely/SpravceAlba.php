<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceAlba
{

	// Vrátí článek z databáze podle jeho URL
	public function vratAlbum($url)
	{
		return Db::dotazJeden('
			SELECT *
			FROM alba
			WHERE url = ?
		', array($url));
	}


	public function vratSeznamAlb()
	{

		return Db::dotazVsechny('
			SELECT * 
			FROM alba
			ORDER BY datum_pridani DESC
			');
	}

	public function vratEditAlba($url)
	{
		return Db::dotazJeden('
		SELECT *
		FROM alba
		WHERE url = ?
	', array($url));
	}

	public function ulozAlbum($id, $alba)
	{
		if (!$id)
			Db::vloz('alba', $alba);
		else
			Db::zmen('alba', $alba, 'WHERE id_alba = ?', array($id));
	}

	public function odstranAlbum($id)
	{
		Db::dotaz('
	DELETE FROM alba
	WHERE url = ?
	', array($id));
	}
}
