# LearnBox
Repozitorij vsebuje datoteke za postavitev vsebnikov Docker za testiranje delovanja nadgrajene različice R paketa [**learnr**](https://github.com/tadson10/learnr) in strežnika [**Jobe**](https://github.com/tadson10/jobe). Paket **learnr** omogoča enostavno izdelavo interaktivnih lekcij za učenje R in Node.js (JavaScript), **Jobe** pa poskrbi za izvajanje kode JavaScript v peskovniku.

Vključeni videoposnetek v interaktivni lekciji z naslovom **Learnr osnovno delovanje** je pridobljen s platforme Youtube zgolj za prikaz delovanja funkcionalnosti in ni del diplomske naloge (vir videoposnetka: https://youtu.be/uVwtVBpw7RQ).

1. Prenesemo vsebino repozitorij na disk
2. V konzoli oz. terminalu se pomaknemo v korensko mapo prenešenega repozitorija.
```
docker-compose up --build -d
```
Pri tem je pomembno, da so vrata *3838, 4000, 3000-3100* na napravi prosta, v nasprotnem primeru vsebniki Docker ne bodo delovali pravilno.

3. V brskalniku odpremo http://localhost:3838/OsnovnoDelovanje funkcionalnosti osnovne različice paketa) ali http://localhost:3838/PrimerIzboljsav (izvedene izboljšave), kjer se nahajata pripravljena primera interaktivnih lekcij.
4. Za dostop do pripravljene Swagger UI dokumentacije REST API-ja strežnika Jobe, odpremo http://localhost:4000/jobe/application/documentation. Za testiranje delovanja lahko uproabimo testi API ključ `dcc9a835-9750-4725-af5b-2c839908f71`.

Izdelek je del diplomske naloge **Podpora interaktivnim lekcijam v izvajalnem okolju Node.js** (Fakulteta za računalništvo in informatiko, Univerza v Ljubljani).