<?php


// Správce uživatelů redakčního systému
class SpravceUzivatelu
{

    // vytvoření random heska
    public function vytvorHeslo()
    {

        $str = 'abcdefghchijklmnopqrstuvwxyz0123456789';
        $heslo = substr(str_shuffle($str), -8);

        return $heslo;
    }

    // Vrátí otisk hesla
    public function vratOtisk($heslo)
    {
        return password_hash($heslo, PASSWORD_DEFAULT);
    }

    public function registruj($jmeno, $heslo)
    {
        $uzivatel = Db::dotazJeden('
         SELECT id_uzivatel, jmeno, admin, heslo
         FROM uzivatel
         WHERE jmeno = ?
     ', array($jmeno));

        if ($uzivatel) {
            throw new ChybaUzivatele('Jméno je již zaregistrované!');
        } else {
            $uzivatel = array(
                'jmeno' => $jmeno,
                'heslo' => $this->vratOtisk($heslo),
            );
            try {
                Db::vloz('uzivatel', $uzivatel);
            } catch (PDOException $chyba) {
                throw new ChybaUzivatele('Uživatel s tímto jménem je již zaregistrovaný.');
            }
        }
    }
    // Přihlásí uživatele do systému
    public function prihlas($jmeno, $heslo)
    {
        $uzivatel = Db::dotazJeden('
            SELECT id_uzivatel, jmeno, admin, heslo
            FROM uzivatel
            WHERE jmeno = ?
        ', array($jmeno));
        if (!$uzivatel || !password_verify($heslo, $uzivatel['heslo']))
            throw new ChybaUzivatele('Neplatné jméno nebo heslo.');
        $_SESSION['uzivatel'] = $uzivatel;
    }

    // Odhlásí uživatele
    public function odhlas()
    {
        unset($_SESSION['uzivatel']);
    }

    // Vrátí aktuálně přihlášeného uživatele
    public function vratUzivatele()
    {
        if (isset($_SESSION['uzivatel']))
            return $_SESSION['uzivatel'];
        return null;
    }
}
