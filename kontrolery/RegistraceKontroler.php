<?php

// Controller pro zpracování článku

class RegistraceKontroler extends Kontroler
{
	public function zpracuj($parametry)
	{
		// Hlavička stránky
		$this->hlavicka['klicova_slova'] = 'Registrace';

		if ($_POST) {

			try {
				$spravceUzivatelu = new SpravceUzivatelu();
				$heslo = $spravceUzivatelu->vytvorHeslo();
				$spravceUzivatelu->registruj($_POST['jmeno'], $heslo);

				$odesilacEmailu = new OdesilacEmailu();

				$vygHeslo = "Toto je tvé vygenerované heslo:";
				$zmenHeslo = "Své heslo můžeš změnit na této stránce: http://reslerad.mp.spse-net.cz/zmenaHesla";
				$zprava = $vygHeslo . " " . $heslo . "\r\n" . $zmenHeslo;
				$odesilacEmailu->odesliSAntispamem($_POST['rok'], "777171656tata@gmail.com", "Heslo pro přihlášení na web: ", $zprava, $_POST['email']);

				$this->pridejZpravu('Byl jste úspěšně zaregistrován. Nyní můžete toto okno zavřit.');

				$this->presmeruj('registrace');
			} catch (ChybaUzivatele $chyba) {
				$this->pridejZpravu($chyba->getMessage());
			}
		}

		// Nastavení šablony
		$this->pohled = 'registrace';
	}
}
