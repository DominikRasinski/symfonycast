# Repozytorium do ćwiczenia Symfony

Informacje oraz pojekty które będą tutaj powstawać pochodzą z:
📚 https://symfonycasts.com - informacje na temat `Symfony` </br>
📚 https://www.freecodecamp.org/news/the-php-handbook/#heading-object-oriented-programming-in-php - informacje na temat `PHP`

## Uruchamianie aplikacji

Aby uruchomić aplikacje na serwerze należy przejść do folderu projektu i uruchomić komendę

> najpierw trzeba posidać zainstalowane takie rzeczy jak:
> PHP
> sudo apt-get install php8.3-xml
> Composer
> Symfony CLI


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

## Model

Modele wykorzystywane są do modelowania obiektów albo klas. Pozwalają na lepsze zorganizowanie życiem obiektów. Oraz zadaniem modelu jest ptrzetrzymywanie danych i udostępnianiu interfejsu pozwalającego te dane pozyskać

## Repozytorium

Powszechnym zadaniem repozytorium jest pozyskywanie danych na przykład z zapytań do bazy danych, można rzec że są kontraktem pod który będzie tworzony kod jak obsłużyć dane zapytanie. To zazwyczaj jest wykorzystywane do tego, jak końcuwka z backendu jeszcze nie isntieje.

Repozytorium opiera się na modelu danego obiektu albo klasy i udostępnia metody pozwalające na szybkie pozyskanie określonych wartości na podstawie danego obiektu.

Repozytoria są bardzo dobrym sposobem na mockowanie zasady działania end-pointów jakie będą przygotowane przez backend, oraz Repozytorium przygotowuje interfejs dla backendu aby zapewnić backend z jakich metod będziemy korzystać.

## Autowirie

W Symofny posiadamy mechanizm pozwalający na automatyczne dodawanie zależności do projektu, zawzwyczaj chcemy nowe zależności dodać do serwisu. Dlatego powstał mechanizm autowire.

Przykład użycia autowire to:

Przykład poprawnego wykonania autowire w serwisie

```php
class StarshipRepository
{
    public function __construct(private LoggerInterface $logger)
    {
    }
}
```
Autowire działa w konstuktorze klasy dla serwisów lub innych klas NIE będących kontrolerami

W Symfony kontrolery zazwyczaj używają serwisów za pomocą dodawania ich jako argument samego kontrolera, zwane `method injection`.
Możan oczywiście dodawać nowe srwisy za pomocą wstrzykiwania ich jako argumenty do samego konstruktora klasy. Ale podczas dodawania serwisu do kontruktora w kontrolerze spowoduje, że każdy `route` będzie inicjalizować dany serwis lub serwisy, co może być zamierzone ale może wpłynąć na optymalizację aplikacji. Dlatego lepszym sposobem dodawania serwisów do kotrolera jest dodawanie ich za pomocą `method injection`

Ten przykład działa tylko dla `Controllera` i wykorzystuje sposób `metod injection`. Podczas dodawania serwisu jako argumnet metody, to serwis będzie inicjalizowany tylko dla danej metody w której został dodany.

```php
 #[Route('', methods: ["GET"])]
    public function getCollection(LoggerInterface $logger, StarshipRepository $repository): Response
    {
        $starships = $repository->findAll();
        return $this->json($starships);
    }
```
Gdzie dodanie słowa `LoggerInterface $logger` do metody klasy, spowoduje automatyczne wpięcie serwisu o id LoggerInterface

Odwołanie do serwisu:
```php
use Psr\Log\LoggerInterface;
```

Plik z tym przykładem to `StarshipApiController.php`

## Zapytania HTTP

Aby wukonać zapytanie Http w aplikacji symfony najpierw musimy zainstalować komponent `http-client`

```bash
composer require symfony/http-client
```
Po zainstalowaniu będziemy mogli wykorzystać komponent w aplikacji na przykład w kontrolerze za pomocę `method-injection`

```php
#[Route('/', name: 'app_homepage')]
    public function homepage(
        StarshipRepository $starshipRepository,
        HttpClientInterface $client,
        ): Response
    {
        $response = $client->request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');
        $issData = $response->toArray();
    }
```
Tylko w takim momencie aplikacja podczas każdego odwiedzenia kontrolera, czyli ścieżki głównej `/` będzie wykonywać zapytanie za pomocą klienta Http. A żeby zapytania nie wypływały za bardzo na działanie strony warto takie zapytanie dodać do pamięci `cache`.

## Cache Service and Cache Pools

Serwisy pozwalające na zarządzanie pamięcią `cache` są dostępne od razu do użycia w aplikacji Symfony, bez potrzeby instalacji nowych komponentów albo bundli. Aby sprawdzić dostępne serwisy możemy skorzystać z komendy:

```bash
php bin/console debug:autowiring cache
```

Dodanie obługi serwisu `cache` polega na dodaniu tak samo jak innych serwisów na przekazaniu go za pomocą argumentu w metodzie w zależności, czy to `kontroler` czy `serwis`. W kontrolerze możemy to robić za pomocą `method-injection` a w serwisie jako argument konstruktora klasy.

Przykład użycia:

```php
$issData = $cache->get('iss_location_data', function (ItemInterface $item) use ($client): array {
    $item->expiresAfter(5);
    $response = $client->request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');
    return $response->toArray();
});
```

* Zmienna `$item` pochodzi z `ItemInterface` pozwaląjący na ustawienie po jakim czasie cache ma zostać zwolniony.

Cache jest przetrzymywany w domyślnej ścieżce projektu `var/cache/dev/pools/`, aby zwolnić cache aplikacji możemy usunąć cały folder `/app` który odpowiada pamięci cache aplikacji. Ale lepszy sposobem będzie skorzystanie z komend w terminalu:

Komenda pozwalająca na sprawdzenie jakie posiadamy aktualnie pojemniki z cachem
```bash
php bin/console cache:pool:list
```
lub
```bash
symfony console cache:pool:list
```

Komeda usuwająca cache aplikacji `cache.app`
```bash
php bin/console cache:pool:clear cache.app
```

### Sprawdzenie aktualnej konfigruacji aplikacji

Aby sprawdzić aktualną konfigurację możemy skorzystać z komendy
```bash
symfony console debug:config framework
```

Aby sprawdzić całą konfigurację aplikacji skorzystamy z komendy:
```bash
symfony console config:dump framework
```

Możemy również ograniczyć informacje jakie mają się wyświetlać do danego serwisu:
```bash
symfony console config:dump framework cache
```

Aby edytować konfigurację `cache` lub innej części aplikacji możemy tego dokonać za w plikach pod ścieżką `config/packages/`. Na przykład w pliku `config/packages/cache.yaml` edytujemy aby cache był tylko aktywny do momentu przeładowania całej aplikaji poprzez dodanie:

```yaml
# APCu
app: cache.adapter.array
```

Co spowoduje, że serwis `cache` będzie korzystać teraz z adaptera `array`