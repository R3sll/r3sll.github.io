<?php

// Třída poskytuje metody pro správu článků v redakčním systému
class SpravceVypisuFotek
{

	// Vrátí článek z databáze podle jeho URL
	public function vratFotku($url)
	{
		return Db::dotazJeden('
        	SELECT * FROM alba AS a
        	JOIN fotografie AS f ON f.alba_id = a.id_alba
        	WHERE url = ? 
		', array($url));
	}

	public function vratSeznamFotek($url)
	{
		return Db::dotazVsechny('
			SELECT * FROM alba AS a
        	JOIN fotografie AS f ON f.alba_id = a.id_alba
        	WHERE url = ?
		', array($url));
	}


	public function vratSeznamVsechFotek()
	{
		return Db::dotazVsechny('
			SELECT * FROM alba AS a
        	JOIN fotografie AS f ON f.alba_id = a.id_alba
        	
		',);
	}

	public function zjistiId(){
		Db::dotazJeden('SELECT MAX(id_fotografie) AS id FROM fotografie where alba_id = 3');
	}

	public function vlozF($cesta, $album)
	{
		Db::dotaz('INSERT INTO fotografie (cesta, alba_id) values (? , ?)', array($cesta, $album));
	}


	public function vratFotograf($url)
	{
		return Db::dotazJeden('
        	SELECT * FROM alba AS a
        	JOIN fotografie AS f ON f.alba_id = a.id_alba
        	WHERE id_fotografie = ? 
		', array($url));
	}


	public function ulozFotky($alb, $obr)
	{

		foreach ($_FILES as $obr) {
			if ($obr['error'] == 4) {
				continue;
			} else {
				$obrname = $obr['name'];
				$obrtmpname = $obr['tmp_name'];

				$gal_cesta = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/";

				move_uploaded_file($obrtmpname, $gal_cesta . $obrname);

				$ulozjmeno = "assets/uploads/" . $obrname;

				$this->vlozF($ulozjmeno, $alb);
			}
		}
	}

	public function odstranFotku($fotka)
	{

		$celaFotka = $this->vratFotograf($fotka);

		$cestaFotky = $celaFotka['cesta'];
		$cestaFotky = $_SERVER['DOCUMENT_ROOT'] . "/" . $cestaFotky;
		if ($cestaFotky) {
			Db::dotaz('DELETE FROM fotografie WHERE id_fotografie = ?', array($celaFotka['id_fotografie']));
			unlink($cestaFotky);
		} else {
			throw new ChybaUzivatele('Neexistuje složka');
		}
	}
}
