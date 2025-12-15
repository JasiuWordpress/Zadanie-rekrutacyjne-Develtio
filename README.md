# Zadanie-rekrutacyjne-Develtio

Do aktywacji wtyczki potrzebna jest wtyczka acf. Na register hooku dalem sprawdzenie czy jesli nie to deaktywuje wtyczke.

I tutaj nie byłem pewny co zrobić bo pojawiło się ,,**Permissions** - czy user ma uprawnienia do rejestracji" więc stworzyłem prosty sytem logowania rejestracji przez co tylko zalogowanym uzytkownikom wyswietla sie formularz i tylko zalogowani uzytkownicy moga sie zapisac na event.

Chciałem zrobić cruda na moje-konto i po stronie admina ale nie starczylo mi czasu (przepraszam najmocniej ale w weekend mialem wyjazd z rodziną i dopiero w niedziele wieczor mialem chwilke zeby usiasc).

Odnosnie dzialania endpointu sprawdzamy nonce i weryfikujemy -> sprawdzamy czy user jest zalogowany -> sprawdzamy czy pola sa wypelnione -> sprawdzamy czy są jeszcze miejsca i czy user juz nie jest zapisany  i zwracam proste odpowiedzi.
Obsluga po stronie js tez jest prosta dalem alerty i przy zapisie usuwa forma bo jak juz ktos jest zapisany to nie moze drugi raz. Endpoint by to wylapal ale stwierdzilem ze moze to troche lepsze rozwiazanie.

Odnosnie wygladu bo to wtyczka to nie moge sobie zrobic poprostu pliku single-event.php to zrobilem template_include i sprawdzam czy jest juz w motywie taki plik jesli jest to ma pierwszenstwo (jesli ktos w przyszlosci chcialby  nadpisac) jesli nie to pobiera nasz.
Tak samo z archive.
Dodalem tez plik enque i do szybkiej stylizacji uzylem boostrapa zeby tylko jakas strukture zachowac.

Odnosnie rejestracji i logowania tutaj nie bylo tego w poleceniu wiec zrobilem to ,,na szybko" i tez nie bylem pewny czy napewno o to chodziło - nie sprawdzam dlugosci haseł itd. (normalnie bym to robił*).
Zrobilem wykluczenie ze nie da sie z tych formularzu logowac do admina.
Ukrylem tez pasek ,,admina" dla nie adminow i jak user probuje wejsc na wp-admin to go przekierowuje na moje-konto.


Odnosnie acf to zrozumialem ze ten nasz plik ma rejestrowac fieldy ale jesli nie ma acfa to i tak nie zarejestruje dlatego do aktywacji wtyczki wymuszam acf.


Strona wtyczki - tutaj wlasnie idealnie to zrobilbym cruda ale nie starczylo czasu wiec tylko wyswietla eventy i mozna zobaczyc kto sie zapisal z linkiem do profilu.


Odnosnie uzycia AI to uzywalem szczegolnie do tej czesci z logowaniem i rejestracja - ChatGpt.
Przy reszcie zadań staralem sie ograniczyć ale jak hooka nie znalem albo nie bylem czegos pewny to korzystalem z wp-codex i chatgpt.


Mam nadzieję, że to co zrobiłem wystarczy - bardzo zalezy mi na tej pracy i obiecuje, ze nie zawiode :D


