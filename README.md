# Repozytorium do ćwiczenia Symfony

Informacje oraz pojekty które będą tutaj powstawać pochodzą z:
📚 https://symfonycasts.com - informacje na temat `Symfony` </br>
📚 https://www.freecodecamp.org/news/the-php-handbook/#heading-object-oriented-programming-in-php - informacje na temat `PHP`

## Uruchamianie aplikacji

Aby uruchomić aplikacje na serwerze należy przejść do folderu projektu i uruchomić komendę

```bash
symfony serve
```

## Struktura projektu

Kazdy projekt stworony przy pomocy `Symfony` posiada trzy ważne elementy jak folder `public`, `src` oraz `vendor`.

> folder `vendor` jest nie widoczny w repozytorrium ponieważ przechowuje wszystkie pakiety instalowane za pomocą menadżera pakietów `composer`

1. Folder `public` przechowuje jeden plik `index.php` który jest odpowiedzialny za wszystkie operacje `response/request` jakie będą się odbywać w aplikacji. Zazwyczaj plik `index.php` jest nie ruszany bo nie wymaga, żadnej modyfikacji jest tak zwanym `fron-controllerem` odpowiedzialnym za komunikacje.
2. Folder `src` posiada w sobie dwa elementy takie jak folder `Controller` oraz plik `Kernel.php` nas odbchodzi folder `Controller` to w nim będą się znajdować nowe klasy kontrolerów odpowiedzialne za przedstawianie kontentu.
3. Folder `vendor` jest odpowiedzialny za przechowywanie wszystkich zależności jakie wykorzystujemy w projekcie, jest odtwarzny za pomocą menadżera pakietów `composer`.

## Controller & Route

### Route
Przed każdą metodą kontrolera odpowiedzialną za działanie wybranej strony musimy dodać atrybut pozwalający na określenie pod jaką ścieżką metoda kontrolera odpowiedzialna za działanie strony ma się uruchomić

```php
class MainController // kontroler
{
    #[Route('/')] // atrybut dodawany przed kontrolerem 'Route' jest odpowiedzialny za tworzenie ścieżki.
    public function homepage() // metoda kontrolera która zostanie uruchomiona w momencie odwiedzenia ścieżki '/'
    {
    }
}
```

> Trzeba zauważyć, że attybut `#[Route('/')]` jest dostępny w wersji `PHP 8` oraz jego działanie przyponia działanie `dekoratora` czyli metody pozwalającej na modyfikowanie wyniku klasy, metody klasy czy właściwości klasy poprzez zewnętrzą ingerencję bez zmiany kodu źródłowego klasy.

Aby zdefiniować ścieżkę dla metody kontrolera w starszej wersji `PHP` możemy skorzystać z takich rozwiązań trzeba jednak zauważyć, że starsze rozwiązania zazwyczaj wymagają instalacji dodatkowych bibliotek:

1. Adnotacje w komentarzach docblock (Doctrine Annotations)
2. Konfiguracja w pliku YAML `config/routes.yaml`
3. Konfiguracja w pliku XML `config/routes.xml`
4. Definiowanie w PHP (Fluent Routing) `config/routes.php`

### Controller

Kontroler jest klasą odpowiedzialną za wygenerowanie strony, może ona zwrócić różne typy danych, takie jak HTML, JSON itp.

Nazwa pliku klasy musi być taka sama jak nazwa klasy kontrolera inaczej `PHP` zwróci błąd, że nie mógł znaleźć takiej klasy.

```php
class MainController // kontroler
{
  // kod do wykonania
}
```
> Kontroler `MainController` musi być przechowywany przez plik o takiej samej nazwie `MainController.php` w innym przypadku `PHP` zwróci bład.

```
src
  |
  |_Controller
        |
        |_MainController.php <-- kontroller MainController
```

📚 https://symfony.com/doc/current/controller.html - przydatna lektura o kontrolerach

## Services

> Serwisy to tak naprawdę obiekty które zwracają dane podczas działania jak naprzykład kontroler zwracający odpowiedź

