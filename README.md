Warhammer TOS
=============

Toto jsou soubory příkladu použití systému na tvorbu pravidel [ULRIK](ulrik.irkalla.cz), tak jak byl použit na LARPové bitvě Warhammer - The Other Sides IV. Jedná se o stejnou verzi, která běží na adrese http://warhammer.irkalla.cz.

Jedná se o nejkomplexnější příklad, který je velmi podobný tomu, na čem běžela naše bitva. Celá aplikace je napsaná v php pomocí [Nette frameworku](http://nette.org). 

Také podotýkám, že tento příklad je asi nejméně komentovaný ze všech, takže není úplně snadné se v něm orientovat. Je nutná znalost Nette, OOP a také XML a XSL.         

Instalace
---------

Zkopírujte všechny soubory z tohoto archívu do adresáře, kde se k nim dostane Váš webový server, a následně upravte soubor app/config.neon, ve kterém nastavte správné údaje k připojení k databázi. V souboru warhammer.sql najdete sql skript, který ve vaší databázi vytvoří potřebné tabulky. Pozornost věnujte zejména tabulce users, kde jsou uloženy přihlašovací údaje testovacích hráčů (mail, plaintext).   

Nyní stačí navést webový server do správné složky a mělo by to běžet.

Použití
-------

Pokud byste chtěli tento projekt využít na nějaké své akci, máte k tomu můj souhlas, pokud nebudete nehorázně kopírovat naší práci a vydávat jí za svoji vlastní. Proto bych doporučil změnit vizuální podobu stránek, pravidel, udělat si vlastí logo atd... Zároveň by bylo fér se zmínit se na nových webovkách o tom, čí práci využíváte.  

Pravidla jednotlivých postav se nacházejí ve složce units a pokud byste jim rádi více rozuměli, stáhněte si ukázkové soubory http://ulrik.irkalla.cz/files/noble.xml a http://ulrik.irkalla.cz/files/noble_wargear.pdf, které obsahují velké množství poznámek.

V pravidlech můžete narazit na výrazy, které se mohou vztahovat k obecným pravidlům naší bitvy. Ty si můžete stáhnout na adrese http://ulrik.irkalla.cz/files/pravidla.pdf.