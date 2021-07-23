<?php

class SpravceKalendare
{

  public function vratUdalost()
  {
    return Db::dotazJeden('
            SELECT d.nazev_tymu AS domaci, h.nazev_tymu AS hoste, id_zapasu, nazev_kategorie, id_zapasu, caskonani, domaci_vysledek, hoste_vysledek, url FROM vysledky_zapasu AS vz 
            JOIN kategorie ON kategorie_id = id_kategorie
            JOIN tymy AS d on vz.domaci = d.id_tymy 
            JOIN tymy AS h on vz.hoste = h.id_tymy
            WHERE id_zapasu = ?
		');
  }

  public function vratSeznamUdalosti()
  {
    return Db::dotazVsechny('
		    SELECT d.nazev_tymu AS domaci, h.nazev_tymu AS hoste, id_zapasu, nazev_kategorie, id_zapasu, caskonani, domaci_vysledek, hoste_vysledek, url FROM vysledky_zapasu AS vz 
            JOIN kategorie ON kategorie_id = id_kategorie
            JOIN tymy AS d on vz.domaci = d.id_tymy 
            JOIN tymy AS h on vz.hoste = h.id_tymy
            ORDER BY caskonani
		',);
  }


public function vratPagVysledku($strana, $naStranu)
	{
		return Db::dotazVsechny('SELECT d.nazev_tymu AS domaci, h.nazev_tymu AS hoste, id_zapasu, nazev_kategorie, id_zapasu, caskonani, domaci_vysledek, hoste_vysledek, url FROM vysledky_zapasu AS vz 
    JOIN kategorie ON kategorie_id = id_kategorie
    JOIN tymy AS d on vz.domaci = d.id_tymy 
    JOIN tymy AS h on vz.hoste = h.id_tymy
    ORDER BY caskonani ASC LIMIT ?, ?', array(($strana - 1) * $naStranu,$naStranu)
		);
	}
	public function vratPocetVysledku()
	{
		return Db::dotazJeden('SELECT COUNT(*) AS cnt FROM vysledky_zapasu');
	}
}