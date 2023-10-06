Poprzednie wersje _(aktualna wersja to 1.7.*)_:

* [WordPress Framework v1.0](https://framework.gbiorczyk.pl/v/1.0)
* [WordPress Framework v1.1](https://framework.gbiorczyk.pl/v/1.1)
* [WordPress Framework v1.2](https://framework.gbiorczyk.pl/v/1.2)
* [WordPress Framework v1.3](https://framework.gbiorczyk.pl/v/1.3)
* [WordPress Framework v1.4](https://framework.gbiorczyk.pl/v/1.4)
* [WordPress Framework v1.5](https://framework.gbiorczyk.pl/v/1.5)
* [WordPress Framework v1.6](https://framework.gbiorczyk.pl/v/1.6)

## Spis treści

* Uruchomienie
  * [Instalacja paczki](#instalacja-paczki)
  * [Inicjalizacja klasy](#inicjalizacja-klasy)
  * [Kompatybilność aktualizacji](#kompatybilność-aktualizacji)
* Typy postów i taksomonie
  * [Rejestracja własnego typu postu](#rejestracja-własnego-typu-postu) **_(post-types.php)_**
  * [Rejestracja taksonomii](#rejestracja-taksonomii) **_(taxonomies.php)_**
  * [Nowa struktura motywu](#nowa-struktura-motywu)
  * [Przyjazne linki](#przyjazne-linki)
* Tłumaczenia **_(translate.php)_**
  * [Tłumaczenie JS](#tłumaczenie-js)
  * [REST API](#rest-api)
  * [Wyłączanie języków](#wyłączanie-języków)
  * [Unikalne slugi](#unikalne-slugi)
* Includowanie plików **_(include.php)_**
  * [Includowanie plików CSS](#includowanie-plików-css)
  * [Includowanie plików JS](#includowanie-plików-js)
  * [Includowanie plików PHP](#includowanie-plików-php)
* ACF **_(acf.php)_**
  * [Wybieranie ikon](#wybieranie-ikon)
  * [Options Pages](#options-pages)
  * [Flexible Content](#flexible-content)
* Panel administracyjny **_(admin.php)_**
  * [Menu w panelu administracyjnym](#menu-w-panelu-administracyjnym)
  * [Konfiguracja TinyMCE](#konfiguracja-tinymce)
  * [Wyłączanie Gutenberga](#wyłączanie-gutenberga)
  * [Lista postów i kategorii](#lista-postów-i-kategorii)
* Ustawienia **_(settings.php)_**
  * [Rozmiary obrazków](#rozmiary-obrazków)
  * [Rejestracja menu](#rejestracja-menu)
  * [Blokada aktualizacji pluginów](#blokada-aktualizacji-pluginów)
  * [Konfiguracja bezpieczeństwa](#konfiguracja-bezpieczeństwa)
  * [Dozwolone typy plików przy uploadzie](#dozwolone-typy-plików-przy-uploadzie)
* [Cache strony](#cache-strony) **_(cache.php)_**
* Formularze kontaktowe **_(forms.php)_**
  * [Wywołanie](#wywołanie)
  * [Zasada działania](#zasada-działania)
  * [Lista wspieranych pól](#lista-wspieranych-pól)
  * [Walidacja](#walidacja)
  * [Formaty daty](#formaty-daty)
  * [Ustawienia formularza](#ustawienia-formularza)
  * [Domyślne wartości](#domyślne-wartości)
  * [Kod formularza](#kod-formularza)
  * [Wysyłanie formularza](#wysyłanie-formularza)
  * [Kolekcje warunków](#kolekcje-warunków)
  * [Dane formularza](#dane-formularza)
  * [Eventy w JS](#eventy-w-js)
  * [Obsługa pól dla plików](#obsługa-pól-dla-plików)
* Narzędzia **_(tools.php)_**
  * [Czyszczenie strony](#czyszczenie-strony)
  * [Statystyki odwiedzin](#statystyki-odwiedzin)
  * [Walidator kategorii](#walidator-kategorii)
* Moduły wbudowane
  * [Przekierowania 301](#przekierowania-301)
  * [Duplikator](#duplikator)
  * [Integracje](#integracje)
  * [Mapa witryny](#mapa-witryny)
  * [Ustawienia e-mail](#ustawienia-e-mail)
  * [Ustawienia SEO](#ustawienia-seo)
  * [Role użytkowników](#role-użytkowników)
* Funkcje pomocnicze
  * [Pobieranie breadcrumbs](#pobieranie-breadcrumbs)
  * [Wyświetlanie favicons](#wyświetlanie-favicons)
  * [Pobieranie z Instagrama](#pobieranie-z-instagrama)
  * [Pobieranie listy języków](#pobieranie-listy-języków)
  * [Pobieranie menu](#pobieranie-menu)
  * [Pobieranie listy kategorii](#pobieranie-listy-kategorii)
  * [Upload plików](#upload-plików)
* Dodatkowe ustawienia
  * [Przekształcanie tekstu przy zapytaniach Ajax](#przekształcanie-tekstu-przy-zapytaniach-ajax)
  * [Filtry do edycji .htaccess](#filtry-do-edycji-.htaccess)
* [Wsparcie SEO](#wsparcie-seo)
* Użyteczności
  * [Ogólne](#ogólne)
  * [W panelu administracyjnym](#w-panelu-administracyjnym)
  * [Dla tłumaczenia](#dla-tłumaczenia)
  * [Dla ACF](#dla-acf)
  * [Dla Yoast SEO](#dla-yoast-seo)

&nbsp;

&nbsp;

# 1. Uruchomienie

## 1.1. Instalacja paczki

### Composer.json

Plik **composer.json** należy umieścić w głównym katalogu motywu.

W pliku `.gitignore` znajdującym się w głównym katalogu projektu należy dodać linię wykluczającą katalog **/vendor**: `**/themes/**/vendor/`.

```
{
  "name": "wordpress-starter-theme",
  "description": "WordPress Starter Theme",
  "authors": [
    {
      "name": "Jootbox",
      "email": "hello@jootbox.eu",
      "homepage": "https://jootbox.eu/",
      "role": "Web Developer"
    }
  ],
  "repositories": [
    {
      "type": "vcs",
      "url": "git@gitlab.com:jootbox/wordpress-framework.git"
    }
  ],
  "config": {
    "gitlab-token": {
      "gitlab.com": "xxxxxxxxxxxxxxxxxxxx"
    }
  },
  "require": {
    "jootbox/wordpress-framework": "1.5.*"
  },
  "prefer-stable": true
}
```

Po dodaniu tego pliku należy otworzyć konsolę w katalogu motywu oraz uruchomić polecenie `composer install`.

&nbsp;

> Repozytorium przechowujące paczkę jest prywatne - **jego pobieranie jest możliwe jedynie posiadając prawidłowy token w pliku composer.json**.
> Token można uzyskać od [autora Frameworka](mailto:hello@jootbox.eu). Pamiętaj, że korzystanie z Frameworka bez posiadania zgody autora, zgodnie z licencją na jakiej jest on dystrybuowany, jest zabronione.

&nbsp;

`[!]` Jeżeli wystąpi problem z pobraniem paczki przy użyciu polecenia `composer install` _(w sytuacji, gdy Composer jest już używany w projekcie)_ należy użyć polecenia `composer update`.

### Aktualizacje

Istnieje możliwość aktualizowania Frameworka do nowszej wersji. Aby tego dokonać trzeba otworzyć konsolę w katalogu motywu oraz uruchomić polecenie `composer update`. Maksymalna obsługiwana wersja jest ograniczona w pliku **composer.json**.

[▲ Spis treści](#spis-treści)

&nbsp;

## 1.2. Inicjalizacja klasy

### Wywołanie

```
<?php

  /* ---
    Name: WordPress Framework
    Author: Jootbox
    License: All rights reserved
  --- */

  require_once 'vendor/autoload.php';
  $framework = new Framework\Framework();

  $path = 'functions/framework/';
  require_once $path . 'post-types.php';
  require_once $path . 'taxonomies.php';
  require_once $path . 'translate.php';
  require_once $path . 'include.php';
  require_once $path . 'acf.php';
  require_once $path . 'admin.php';
  require_once $path . 'settings.php';
  require_once $path . 'cache.php';
  require_once $path . 'forms.php';
  require_once $path . 'tools.php';
```

### Konfiguracja

Pamiętaj, aby utworzyć odpowiednie pliki w katalogu **/functions/framework/** _(wg wzorca powyżej)_ - odpowiednie pogrupowanie funkcji pozwoli na łatwiejsze zarządzanie nimi. Należy `trzymać się zalecanej struktury`, a sam plik **functions.php** poza inicjacją Frameworka nie powinien zawierać żadnych innych kodów.

Lista plików w katalogu `/functions/framework/` jest spójna z głównymi kategoriami _(obok nich podane są również nazwy plików)_ w [spisie treści](#spis-treści) tej dokumentacji, dzięki czemu bez problemu można odpowiednio umieścić daną funkcję we właściwym miejscu.

Komentarz na początku pliku jest istotny, ponieważ informuje o tym, na czym oparty jest motyw i gdzie można uzyskać szczegółowe informacje.

[▲ Spis treści](#spis-treści)

&nbsp;

## 1.3. Kompatybilność aktualizacji

Wersjonowanie Frameworka składa się z 3 członów oddzielonych kropką *(np. `1.2.3` oznacza major = `1`, minor = `2`, release = `3`)*. W przypadku aktualizacji kompatybilność wsteczna zależy od poziomu aktualizacji:
* Major *(brak wsparcia wstecznego, oznacza dużą przebudowę struktury)*
* Minor *(możliwy brak wsparcia wstecznego dla poszczególnych funkcjonalności, zazwyczaj wymaga niewielkich zmian w kodzie lub ustawieniach Frameworka)*
* Release *(pełna kompatybilność wsteczna)*

Dla aktualizacji typu `Major` nie zalecana jest aktualizacja. W przypadku `Minor` należy w miarę możliwości starać się je wykonywać, ponieważ zazwyczaj wnoszą one dużo nowych funkcjonalności oraz poprawek. **Natomiast aktualizacje `Release` należy robić zawsze, kiedy pracuje się nad projektem.**

Opis aktualizacji Minor:
* 1.1 *(pełna kompatybilność z wersją 1.0)*
* 1.2 *(ograniczona kompatybilność z wersją 1.1)*
  * przeniesienie konfiguracji PHPMailer do panelu administracyjnego *(wymaga usunięcia funkcji inicjującej `$framework->settings->action('phpmailer', ...` oraz przepisania ustawień w sekcji ustawień Frameworka w panelu administracyjnym)*
  * usunięcie konfiguracji typów postów dla wyszukiwarki *(wymaga usunięcia funkcji inicjującej `$framework->settings->action('search-posttypes', ...`)*
* 1.3 *(ograniczona kompatybilność z wersją 1.2)*:
  * zmiana kolejności argumentów w filtrach dla formularzy *(wymaga zmian w kodzie w przypadku wykorzystywania filtrów)*:
    * `wpf_forms_values_${form_id}` / `wpf_forms_values`
    * `wpf_forms_email_${form_id}` /  `wpf_forms_email`
  * modyfikacja pól formularza: Date, Time i Datetime *(scalenie w jedno - Date, wymaga zmian typów pól w konfiguracji formularzy, ustawienia prawidłowych formatów dat oraz korekt w kodzie wykorzystującym te trzy typy pól)*
  * modyfikacja pola formularza: reCAPTCHA *(globalna konfiguracja kluczy, wymaga przepisania konfiguracji w sekcji ustawień Frameworka w panelu administracyjnym)*
  * usunięcie globalnego dostępu do instancji Vue.js formularza *(`wpF.vueForm`)*-
* 1.4  _(ograniczona kompatybilność z wersją 1.3)_:
  * zamiana filtra `wpf_contact_form` na akcję `wpf_forms_load`
  * zmiana kolejności argumentów w filtrach dla formularzy  _(wymaga zmian w kodzie w przypadku wykorzystywania filtrów)_:
    * `wpf_forms_field_html_${form_id}` / `wpf_forms_field_html`
    * `wpf_forms_values_${form_id}` / `wpf_forms_values`
    * `wpf_forms_validation_${form_id}` / `wpf_forms_validation`
    * `wpf_forms_send_${form_id}` / `wpf_forms_send`
    * `wpf_forms_email_${form_id}` / `wpf_forms_email`
  * zmiana nazw filtrów i listy argumentów _(wymaga zmian w kodzie w przypadku wykorzystywania filtrów)_:
    * `wpf_helper_breadcrumbs` -> `wpf_breadcrumbs`
    * `wpf_helper_instagram` -> `wpf_instagram`
    * `wpf_helpers_instagram_item` -> `wpf_instagram_item`
    * `wpf_helper_langs` -> `wpf_langs`
    * `wpf_helpers_langs_item` ->` wpf_langs_item`
    * `wpf_helper_menu` / `wpf_helpers_menu` -> `wpf_menu`
    * `wpf_helpers_menu_item` -> `wpf_menu_item`
    * `wpf_helper_terms` / `wpf_helpers_terms` -> `wpf_terms`
    * `wpf_helpers_terms_item` -> `wpf_terms_item`
  * zamiana filtra `wpf_helper_favicons` na akcję `wpf_favicons`
* 1.5 *(ograniczona kompatybilność z wersją 1.4)*
  * załączniki do wiadomości e-mail nie są już dodawane automatycznie _(należy podać ich listę podczas edycji formularza)_

W sytuacji, gdy w projekcie nie są używane funkcjonalności, dla których nie ma pełnego wsparcia lub możliwe jest szybkie dopasowanie kodu bądź ustawień, można bezpiecznie wykonać aktualizację.

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 2. Typy postów i taksomonie

## 2.1 Rejestracja własnego typu postu

### Wywołanie

```
$framework->posttype->action('register', ${args});
```

### Przykład użycia

```
$framework->posttype->action('register', [
  'slug'    => 'events',
  'rewrite' => 'pokoje',
  'icon'    => 'dashicons-admin-home',
  'labels'  => [
    'name' => __('Pokoje', 'lang'),
    'menu' => 'Pokoje',
  ],
  'langs'   => [
    'pl' => 'pokoje',
    'en' => 'rooms',
  ],
  'args'    => [],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | ... | Wartość | Opis |
|:--|:--|:--|:--|
| slug    |          | string  | unikalny slug dla typu postu |
| rewrite |          | string  | slug występujący w adresie URL |
| icon    |          | boolean | slug ikony ([lista](https://developer.wordpress.org/resource/dashicons/))
| labels  |          | array   | ↴ |
|         | name     | string  | nazwa w liczbie mnogiej _(np. Książki czy Listy spraw)_ |
|         | menu     | string  | nazwa opcji w menu _(wartość opcjonalna; jeżeli nie jest dostępna to zostanie użyta wartość `name`)_ |
| langs   |          | array   | wartość opcjonalna; lista tłumaczeń slugu dla innych języków niż domyślny _(nazwa klucza to slug języka, a wartością jest przetłumaczony slug typu postu)_ |
| args    |          | array   | wartość opcjonalna; lista parametrów w formie tablicy, która nadpisuje domyślne argumenty ([źródło](https://codex.wordpress.org/Function_Reference/register_post_type#Arguments)) |

##### `!` Zapoznaj się również z możliwościami [nowej struktury plików motywu](#nowa-struktura-motywu) dla Custom Post Types.

### Niepubliczne typy postów

Czasami w celu ułatwienia zarządzania treścią tworzy się dodatkowe Custom Post Types, dla których jednak nie chcemy tworzyć fizycznych stron. Jest to spowodowane tym, że są one np. wyświetlane tylko w danej sekcji i nie mają swojego archiwum ani pojedynczej strony.

Aby utworzyć prywatny Custom Post Type należy dodać odpowiednie argumenty podczas jego rejestracji:

```
'args' => [
  'public'  => false,
  'show_ui' => true,
],
```

### Dodatkowe informacje

* domyślnie Custom Post Types dodają się w menu na pozycji `30` ([struktura menu](https://developer.wordpress.org/reference/functions/add_menu_page/#menu-structure))
* zachowując domyślne ustawienia pozycji, nad listą typów postów dodany zostaje separator, który oddziela te sekcje od pozostałych _(jest to bardziej przejrzyste dla administratora)_
* domyślna rejestracja Custom Post Type obsługuje jedynie pole tytułu _(pole typu content nie jest potrzebne, ponieważ edycja treści tworzy się się za pomocą pól z pluginu Advanced Custom Fields)_
* dodatkowo obsługiwane są rewizje

### Informacje o tłumaczeniu

* Framework jest kompatybilny z pluginem `Polylang` do tłumaczeń _(dodaje do wersji darmowej część opcji zawartych w wersji PRO)_
* narzędzie jest kompatybilne z pluginem [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/)

[▲ Spis treści](#spis-treści)

&nbsp;

## 2.2. Rejestracja taksonomii

### Wywołanie

```
$framework->taxonomy->action('register', ${args});
```

### Przykład użycia

```
$framework->taxonomy->action('register', [
  'slug'        => 'types',
  'rewrite'     => 'typy',
  'posttypes'   => ['rooms'],
  'is_category' => true,
  'labels'      => [
    'name' => __('Typy', 'lang'),
    'menu' => 'Typy',
  ],
  'langs'       => [
    'pl' => 'typy',
    'en' => 'types',
  ],
  'args'        => [],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | ... | Wartość | Opis |
|:--|:--|:--|:--|
| slug        |          | string  | unikalny slug dla taksonomii _(zalecany wzór: `{posttype}-category`)_ |
| rewrite     |          | string  | slug występujący w adresie URL |
| posttypes   |          | array   | lista slugów Post Types, dla których ma być przypięta ta taksonomia
| is_category |          | boolean | true oznacza użycie taksonomii jako kategorii, a false jako tagów
| labels      |          | array   | ↴ |
|             | name     | string  | nazwa w liczbie mnogiej _(np. Sektory czy Kolory aut)_ |
|             | menu     | string  | nazwa opcji w menu _(wartość opcjonalna, jeżeli nie jest dostępna to zostanie użyta wartość `name`)_ |
| langs       |          | array   | wartość opcjonalna; lista tłumaczeń slugu dla innych języków niż domyślny _(nazwa klucza to slug języka, a wartością jest przetłumaczony slug typu postu)_ |
| args        |          | array   | wartość opcjonalna; lista parametrów w formie tablicy, która nadpisuje domyślne argumenty ([źródło](https://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments)) |

> `!` Zapoznaj się również z możliwościami [nowej struktury plików motywu](#nowa-struktura-motywu) dla Taxonomies.

### Niepubliczne taksonomie

Czasami w celu ułatwienia zarządzania treścią tworzy się dodatkowe taksonomie, dla których jednak nie chcemy tworzyć fizycznych stron. Jest to spowodowane tym, że są one np. wykorzystywane jako filtry i nie mają swoich archiwów.

Aby utworzyć prywatną taksonomię należy dodać odpowiednie argumenty podczas jej rejestracji:

```
'args' => [
  'public'  => false,
  'show_ui' => true,
],
```

### Informacje o tłumaczeniu

* Framework jest kompatybilny z pluginem `Polylang` do tłumaczeń _(dodaje do wersji darmowej opcje zawarte z wersji PRO)_
* narzędzie jest kompatybilne z pluginem [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/)
* jeżeli korzystasz z pluginu [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/) do tworzenia przyjaznych linków, pamiętaj aby tłumacząc taksonomię podawać przetłumaczony slug odpowiadającego typu postu, a nie taksonomii _(w innym przypadku tłumaczenie przywróci domyślną strukturę dla linków do archiwum kategorii)_

[▲ Spis treści](#spis-treści)

&nbsp;

## 2.3. Nowa struktura motywu

Bazowa struktura plików motywu WordPressa zakłada tworzenie dla Custom Post Types oraz Taxonomies następujących plików w katalogu głównym:
 - /archive-`$posttype`.php
 - /single-`$posttype`.php
 - /taxonomy-`$taxonomy`.php

W przypadku większej ich liczby zaczyna to przysparzać pewne problemy - ciężko jest się odnaleźć w tak dużej liczbie plików. Framework pozwala na przeniesienie tych plików do katalogu `templates` wg schematu:
 - /templates/`$posttype`/archive.php _(strona archiwum Post Type)_
 - /templates/`$posttype`/single.php _(pojedyncza strona Post Type)_
 - /templates/`$taxonomy`/index.php _(strona archiwum Taxonomy)_

Zmienne `$posttype` oraz `$taxonomy` oznaczają odpowiednio slug Custom Post Type oraz slug Taxonomy. Powyższa struktura pozwala zachować porządek w motywie. Nie jest ona narzucona, lecz dostępna jako opcja. W przypadku braku tych plików brana pod uwagę będzie domyślna struktura. **Niemniej korzystanie z nowej jest zalecane, nawet w przypadku niewielkiej liczby Custom Post Types i Taxonomies.**

Nazwy plików `archive.php`, `single.php` oraz `index.php` są stałe i nie można ich modyfikować. Operujemy jedynie na nazwach katalogów.

Modyfikacje nie mają żadnego wpływu na pliki [Page Template](https://developer.wordpress.org/themes/template-files-section/page-template-files/), które również powinny się znajdować w katalogu `templates`, w celu zachowania porządku. Dodatkowe pliki nie będą wykrywane przez WP, ponieważ nie mają odpowiedniego komentarza w górnej części pliku PHP.

Aby utworzyć Page Template należy w pliku PHP, utworzonym w katalogu `templates`, dodać następujący komentarz:

    <?php /* Template Name: Example */ ?>

Zamiast frazy `Example` podajemy własną nazwę szablonu.

[▲ Spis treści](#spis-treści)

&nbsp;

## 2.4. Przyjazne linki

Domyślna struktura linków w WordPressie wygląda następująco:
* Custom Post Type > Post
* Taxonomy > Single Term

Struktura ta nie jest w pełni przyjazna pod kątem zarówno SEO, jak i użyteczna dla samych użytkowników, którzy mogą próbować skrócić link, aby przejść wyżej w hierarchi strony. Do tworzenia lepszej struktury zaleca się skorzystanie z pluginu [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/).

Korzystając z niego mamy możliwość utworzenia poniższej struktury linków:
* Custom Post Type > Single Term > Post
* Custom Post Type > Post _(jeżeli nie ma zaznaczonej żadnej kategorii)_
* Custom Post Type > Single Term

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 3. Tłumaczenia

## 3.1. Tłumaczenie JS

### Wywołanie

```
$framework->translate->action('js', ${args});
```

### Przykład użycia

```
$framework->translate->action('js', [
  'example' => __('Przykład', 'lang'),
]);
```

### Dodatkowe informacje

* jako argumenty podajemy tablicę z frazami, które używane są w plikach JS
* klucze elementów tabeli to `slugi`, do których potem odwołujemy się w plikach skryptów
* wartość powinna być tekstem zawartym w [funkcji i18n](https://codex.wordpress.org/I18n_for_WordPress_Developers#Translatable_strings)
* w pliku JS nie wpisujemy wtedy tekstu, tylko nazwę zmiennej _(np. `translate.text`)_
* `wpF.translate` jest stałą nazwą tablicy

`!` Nie należy wpisywać fraz tekstowych w plikach JS. Wszystkie one powinny być dodane w kodzie PHP i przekazywane do JS w formie tablicy.

[▲ Spis treści](#spis-treści)

&nbsp;

## 3.2. REST API

Domyślnie Polylang w wersji darmowej nie oferuje wsparcia dla REST API. Powoduje to następujące problemy:
* funkcja `get_posts()` zwracaja rezultaty bez podziału na języki
* funkcja `get_terms()` zwracaja rezultaty bez podziału na języki
* funkcja `get_field()` odnosząca się do Options Page zwraca wartość z domyślnego języka
* funkcje obsługujące internacjonalizację _(np. `__('...')`)_ wskazują zawsze domyślną wartość

Framework rozwiązuje ten problem automatycznie dodając do funkcji `get_posts()` oraz `get_terms()` parametr `lang`. Jeżeli ten artybut został dodany ręcznie w argumentach funkcji to nie jest on nadpisywany przez globalną funkcję.

Poprzez zmianę domyślnej wartości ustawień regionalnych funkcja `get_field()` zwraca prawidłowe wartości dla danego języka. Dotyczy to pól z Options Page, które są tłumaczone.

Internacjonalizacja również działa prawidłowo, ładując odpowiednie pliki językowe dla motywu oraz samego core WordPressa.

Aby skorzystać z powyższych funkcjonalności należy dodać parametr `lang` w zapytaniu do REST API. Wartością powinien być slug języka złożony z dwóch małych liter, np. `pl`.

## 3.3. Wyłączanie języków

Kolejną funkcjonalnością dostępną we Frameworku jest możliwość wyłączania języków. Działa to inaczej niż w przypadku Polylanga PRO, ponieważ mamy możliwość całkowitego wyłączenia danego języka.

Pozwala to na dodawanie treści w danym języku, bez obawy o użytkowników, którzy mogą dostać dostęp do nieukończonych treści.

Języki, z wyjątkiem domyślnego, można włączać i wyłączać z poziomu panelu administracyjnego, w domyślnej zakładce obsługującej listę języków, dodanej przez wtyczkę Polylang. Obok domyślnych przycisków _Edit_ oraz _Delete_ znajduje się dodatkowy przycisk `Disable` lub `Enable`.

Wyłączony język jest zablokowany w następujących sytuacjach:
* pobieranie postów
* pobieranie taksonomii
* pobieranie listy języków
* wyświetlania postu w danym języku _(zostanie wyświetlony błąd 404)_
* wyświetlania taksonomii w danym języku _(zostanie wyświetlony błąd 404)_
* pobieranie adresu strony głównej

Blokada języka jest wyłączona w panelu administracyjnym oraz dla użytkowników zalogowanych posiadających odpowiednie uprawnienia _(nie role użytkowników - uprawienia są przypisane do roli)_. Domyślnie są to uprawnienia `administrator` oraz `loco_admin`.

Listę tych uprawnień można modyfikować korzystając z następującego filtra:

> W funkcji dostępna jest lista uprawnień oraz obiekt `WP_User` zawierający dane aktualnie zalogowanego użytkownika.

```
add_filter('wpf_polylang_switcher_caps', 'example_callback', 10, 2);

function example_callback($caps, $user)
{
  // $caps array modifications
  return $caps;
}
```

## 3.4. Unikalne slugi

Domyślnie dodając posty lub kategorie należy zachować ich unikalność w obrębie danego Post Type lub Taxonomy. Wbudowane funkcjonalności we Frameworku dają możliwość dodawania identycznych slugów w obrębie tego samego Post Type lub Taxonomy, dla różnych języków. Dotyczy to języków obsługiwanych przez wtyczkę Polylang.

W przypadku postów nadpisana jest domyślna funkcjonalność tworzenia unikalnych slugów. Zmodyfikowane zapytanie do bazy danych uwzględnia wybrany język. Posiadając dwa identyczne slugi podczas włączania ich adresu URL zawsze ładowałby się tylko ten pierwszy, w związku z tym zapytanie do bazy, uruchamiane podczas głównego filtra `query`, również zawiera modyfikacje dla języka.

Narzędzie nie obsługuje hierarchiczności, gdzie slug mógłby być unikalny na podstawie języka oraz rodzica. Ma to na celu uproszczenie działania i większą bezawaryjność.

W przypadku kategorii nie istnieje problem jednakowych slugów podczas edycji oraz uruchamia adresów URL. Jest to dozwolone. Niemniej podczas dodawania nowej kategorii slug będzie generowany w sposób unikalny. Można byłoby go później edytować, ale podobnie jak w przypadku postów został zmodyfikowany mechanizm generowania unikalnych slugów, aby działo się to automatycznie.


[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 4. Includowanie plików

## 4.1. Includowanie plików CSS

### Wywołanie

```
$framework->loader->action({tryb}, ${args});
```

### Przykład użycia

```
$framework->loader->action('css',
  ['public/build/css/styles.css']
);
```

### Dodatkowe informacje

* dostępne tryby:
  * `css` - standardowe ładowanie plików CSS
  * `inline-css` - wyświetlanie zawartości plików CSS w sekcji head _(wyłączone dla localhost)_
  * `admin-css` - ładowanie plików CSS w panelu administracyjnym
* jako argumenty podajemy ścieżkę do pliku lub listę ścieżek w formie tablicy:
  * dla plików lokalnych adres względny _(względem katalogu głównego motywu)_
  * dla plików zewnętrznych adres bezwzględny _(z użyciem http lub https)_
* do adresu pliku dodawana jest wersja zawierająca datę ostatniej modyfikacji pliku _(rozwiązuje to problem cache przeglądarki)_

`!` W przypadku wyświetlania zawartości plików CSS w sekcji head, adresy URL dla obrazków oraz fontów _(`../`, `../../` lub `../../../`)_ zamieniane są na poprawne. Więcej informacji w sekcji [Wsparcie SEO](#wsparcie-seo).

[▲ Spis treści](#spis-treści)

&nbsp;

## 4.2. Includowanie plików JS

### Wywołanie

```
$framework->loader->action({tryb}, ${args});
```

### Przykład użycia

```
$framework->loader->action('js',
  ['public/build/js/scripts.js']
);
```

### Dodatkowe informacje

* dostępne tryby:
  * `js` - standardowe ładowanie plików JS
  * `admin-js` - ładowanie plików JS w panelu administracyjnym
* jako argumenty podajemy ścieżkę do pliku lub listę ścieżek w formie tablicy:
  * dla plików lokalnych adres względny _(względem katalogu głównego motywu)_
  * dla plików zewnętrznych adres bezwzględny _(z użyciem http lub https)_
* do adresu pliku dodawana jest wersja zawierająca datę ostatniej modyfikacji pliku _(rozwiązuje to problem cache przeglądarki)_
* na front-edzie funkcja ta automatycznie `przenosi jQuery do stopki` _(jeżeli jest włączone)_, w celu uzyskania lepszych wyników w testach szybkości strony

[▲ Spis treści](#spis-treści)

&nbsp;

## 4.3. Includowanie plików PHP

### Wywołanie

```
$framework->loader->action('php', ${args});
```

### Przykład użycia

```
$framework->loader->action('php',
  ['functions/directory']
);
```

### Dodatkowe informacje

* jako argumenty przekazujemy adres względny do folderu _(względem katalogu głównego motywu)_ lub listę adresów w formie tablicy
* w danych folderze zostaną zaincludowane wszystkie pliki PHP

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 5. ACF

## 5.1. Wybieranie ikon

### Wywołanie

```
$framework->acf->action('icons', ${args});
```

### Przykład użycia

```
$framework->acf->action('icons', [
  'icon-example-1',
  'icon-example-2',
  'icon-example-3',
]);
```

`[!]` - pamiętaj, aby dodatkowo podpiąć do panelu administracyjnego plik CSS z ikonami wygenerowany przez `Icomoon`

### Dodatkowe informacje

* jako argumenty przekazujemy tablicę z nazwami klas od ikon _(takie, jak są wygenerowane przez `Icomoon`)_
* funkcja zamienia wszystkie pola typu Select _(muszą posiadać slug `icon` oraz mieć zaznaczoną opcję pokazania `ostylowanego interfejsu`)_ na wizualną listę wyboru ikon _(ułatwia to wybór ikon przy ich większej liczbie)_
* lista opcji do wyboru jest uzupełniana automatycznie

[▲ Spis treści](#spis-treści)

&nbsp;

## 5.2. Options Pages

### Wywołanie

```
$framework->acf->action('optionspage', ${args});
```

### Przykład użycia

```
$framework->acf->action('optionspage', [
  'title'       => 'Zarządzanie',
  'slug'        => 'options',
  'icon'        => 'dashicons-admin-tools',
  'pages'       => [
    'header' => 'Nagłówek',
    'footer' => 'Stopka',
  ],
  'notranslate' => [],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| title       | string | tytuł strony opcji |
| slug        | string | unikalny slug strony w menu |
| icon        | string | slug ikony ([lista](https://developer.wordpress.org/resource/dashicons/)) |
| pages       | array  | lista podstron _(klucz tablicy odpowiada za slug, a wartość za tytuł)_ |
| notranslate | array  | slugi podstron, w których pola będą posiadały jedną wartość dla wszystkich języków _(dotyczy pluginu Polylang)_ |

### Usprawnienia dla pluginu Polylang

Domyślnie Polylang nie wspiera tłumaczenia Options Pages. Framework daje możliwość tłumaczenia tych wartości. Dzięki temu dla każdego języka można przypisać inną wartość. Zmiana aktualnego języka odbywa się za pomocą przycisku na górnym pasku w panelu administracyjnym. Dodając Options Page nie trzeba robić żadnych dodatkowych rzeczy. Wartości na front-endzie wyświetlają się automatycznie dla aktywnego języka.

Jeżeli nie chcesz tłumaczyć wartości pól w wybranej Options Page, wystarczy dodać jej slug do tablicy `notranslate`. W sytuacji, gdy wypełniłeś już treści dla danych języków **musisz je usunąć**. Można to zrobić poleceniem w bazie danych:

```
DELETE FROM wp_options WHERE option_name LIKE '%{field_key}%' AND option_name NOT LIKE '%options_{field_key}%'
```

Frazę `{field_key}` podmień na klucz danego pola _(pamiętaj o zmianie prefixu tabeli)_ i powtórz tą operację dla wszystkich pól, których to dotyczy.

[▲ Spis treści](#spis-treści)

&nbsp;

## 5.3. Flexible Content

Jeżeli potrzebujemy określonych pól w każdym layoucie w polu Flexible Content to zamiast dodawać je pojedynczo, możemy skorzystać z filtra, który pozwoli automatycznie umieścić wybrane pola w każdym layoucie dla określonego pola Flexible Content.

### Przykład użycia

```
add_filter('wpf_acf_flexible_fields', 'example_callback', 10, 2);

function example_callback($fields, $field)
{
  if ($field['name'] !== 'sections') return $fields;
  return [
    [
      'label'       => 'Wyłączyć sekcję?',
      'name'        => 'section_is_disabled',
      'type'        => 'true_false',
      'instruction' => '',
    ],
  ];
}
```

Wewnątrz funkcji dostępna jest tablica z listą dodatkowych pól _(domyślnie pusta tablica)_, a także tablica z ustawieniami pola Flexible Content. Pozwala to zdecydować, czy dla danego pola chcemy generować automatycznie dodatkowe pola w każdym layoucie.

W funkcji zwracamy listę dodatkowych pól w formie tablicy. Zostaną one automatycznie dodane na początek każdego layoutu oraz ich tło będzie ciemniejsze, aby je wyróżnić.

Należy pamiętać, aby argument `name` był unikalny. Więcej informacji odnośnie dostępnych ustawień dla pól można znaleźć [w dokumentacji ACF](https://www.advancedcustomfields.com/resources/register-fields-via-php/) w sekcji [Field Settings](https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings), opisującej ustawienia dla funkcji `acf_add_local_field`.

Z podanych danych wartości kluczy `key`, `parent` oraz `parent_layout` są zastępowane wartościami generowanymi automatycznie przez Framework wg określonego wzoru.

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 6. Panel administracyjny

## 6.1. Menu w panelu administracyjnym

### Wywołanie

```
$framework->admin->action('menu', ${args});
```

### Przykład użycia

```
$framework->admin->action('menu', [
  'posts'     => true,
  'pages'     => true,
  'comments'  => false,
  'customize' => false,
  'wp_tools'  => false,
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| posts     | boolean | widoczność sekcji `Wpisy` w menu panelu administracyjnego |
| pages     | boolean | widoczność sekcji `Strony` w menu panelu administracyjnego |
| comments  | boolean | widoczność sekcji `Komentarze` w menu panelu administracyjnego |
| customize | boolean | widoczność sekcji `Wygląd -> Personalizacja` w menu panelu administracyjnego |
| wp_tools  | boolean | widoczność sekcji `Narzędzia -> Dostępne narzędzia, Import oraz Eksport` w menu panelu administracyjnego |

[▲ Spis treści](#spis-treści)

&nbsp;

## 6.2. Konfiguracja TinyMCE

### Wywołanie

```
$framework->admin->action('tinymce', ${args});
```

### Przykład użycia

```
$framework->admin->action('tinymce', [
  'pages_editor' => false,
  'buttons_1'    => [
    'formatselect',
    'bold',
    'italic',
    'bullist',
    'numlist',
    'blockquote',
    'alignleft',
    'aligncenter',
    'alignright',
    'link',
    'wp_more',
    'spellchecker',
    'dfw',
    'wp_adv',
  ],
  'buttons_2'    => [
    'strikethrough',
    'hr',
    'forecolor',
    'pastetext',
    'removeformat',
    'charmap',
    'outdent',
    'indent',
    'undo',
    'redo',
    'wp_help',
  ],
  'formats'      => [
    'h1' => 'Nagłówek 1',
    'h2' => 'Nagłówek 2',
    'h3' => 'Nagłówek 3',
    'h4' => 'Nagłówek 4',
    'h5' => 'Nagłówek 5',
    'h6' => 'Nagłówek 6',
    'p'  => 'Paragraf',
  ],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| pages_editor | boolean | widoczność pola typu `content` podczas edycji podstron |
| buttons_1    | array   | lista przycisków w pierwszej linii w edytorze TinyMCE _(wg wybranej kolejności)_ |
| buttons_2    | array   | lista przycisków w drugiej linii w edytorze TinyMCE _(wg wybranej kolejności)_ |
| formats      | array   | lista dostępnych typów formatów |

### Dodatkowe informacje

* jako klucze w tablicy `formats` przekazujemy tag HTML _(`h1`, `h2`, `h3`, `h4`, `h5`, `h6`, `p`)_
* wartości to nazwy formatów widoczne dla administratora w edytorze
* `!` użycie poszczególnych argumentów funkcji jest opcjonalne _(jeżeli nie ma potrzeby zmiany danych parametrów, nie trzeba ich podawać)_

[▲ Spis treści](#spis-treści)

&nbsp;

## 6.3. Wyłączanie Gutenberga

### Wywołanie

```
$framework->admin->action('gutenberg', ${arg});
```

### Przykład użycia

```
$framework->admin->action('gutenberg', false);
```

### Dodatkowe informacje

* jako argument przekazujemy wartość boolean, która oznacza, czy chcemy włączyć bądź wyłączyć globalnie edytor Gutenberg
* domyślnie Gutenberg jest wyłączony _(nie ma potrzeby używania akcji, aby przekazać wartość `false`)_

[▲ Spis treści](#spis-treści)

&nbsp;

## 6.4. Lista postów i kategorii

### Kolumny

Moduł pozwala na dodawanie własnych kolumn na liście postów oraz kategorii zarówno dla typów wbudowanych, jak i własnych. W tym celu należy skorzystać z filtra _(przykład pokazuje dodawanie dwóch dodatkowych kolumn, w tym pierwszą z opcją sortowania)_:

    add_filter('wpf_manage-{$slug}_columns', 'example_callback');

    function example_callback($columns)
    {
      return array_merge($columns, [
        'count' => [
          'label'        => __('Licznik', 'lang'),
          'action_value' => function($objectId) {
            return get_field('count', $objectId);
          },
          'action_sort'  => function($args, $defaultArgs, $order) {
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = 'count';
            return $args;
          },
        ],
        'name' => [
          'label'        => __('Nazwa', 'lang'),
          'action_value' => function($objectId) {
            return get_field('name', $objectId);
          },
          'action_sort'  => false,
        ],
      ]);
    }

Filtr współpracuje zarówno z Post Types, jak i Taxonomies. W jego nazwie zamiast `{$slug}` należy podać slug typu postu lub taksonomii.

W funkcji zwracamy listę dodatkowych kolumn. Klucz oznacza slug kolumny, a wartość to tablica z listą ustawień:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| label        | string   | wyświetlana nazwa kolumny |
| action_value | resource | funkcja pozwalająca zwrócić wyświetlaną wartość w danej kolumnie _(`$objectId` oznacza ID postu lub kategorii)_ |
| action_sort  | resource | funkcja pozwalająca sortować listę postów lub kategorii poprzez zwrócenie argumentów do zmiany w Query _(parametry oznaczają odpowiednio listę argumentów do nadpisania, listę domyślnie użytych argumentów oraz aktualny rodzaj sortowania)_ - aby wyłączyć sortowanie należy usunąć tą wartość lub ustawić jako `false` |

Listę dostępnych argumentów można znaleźć w dokumentacji funkcji `get_posts` oraz `get_terms`. Pełna ich lista znajduje się również [tutaj](https://www.billerickson.net/code/wp_query-arguments/).

> Domyślnie dla każdego Post Type dodawane są automatycznie kolumny z taksonomiami do niego podpiętymi. W kolumnie wyświetlana jest lista kategorii dla danego postu. Każda z nich jest linkiem pozwalającym wyświetlić wszystkie posty z danej kategorii.

### Kolejność kolumn

Istnieje również możliwość zmiany kolejności kolumn oraz ich usuwania poprzez następujący filtr _(przykład pokazuje usunięcie kolumny z datą publikacji postu)_:

    add_filter('wpf_manage-{$slug}_columns_order', 'example_callback');

    function example_callback($columns)
    {
      foreach ($columns as $index => $name) {
        if ($name === 'date') unset($columns[$index]);
      }
      return $columns;
    }

Filtr współpracuje zarówno z Post Types, jak i Taxonomies. W jego nazwie zamiast `{$slug}` należy podać slug typu postu lub taksonomii.

Jako parametr `$columns` przekazywana jest lista kluczy kolumn, których kolejność można dowolnie modyfikować lub usuwać wybrane z nich, a następnie należy je zwrócić.

### Filtrowanie

Możliwość tworzenia własnych filtrów jest dostępna korzystając z filtra _(przykład pokazuje dodawanie dwóch dodatkowych filtrów - pierwszego filtrującego według tablicy wartości oraz drugiego wg tablicy z elementami zagnieżdżonymi - budowaniem drzewka z podanych wartości zajmuje się już skrypt)_:

    add_filter('wpf_manage-{$slug}_filters', 'example_callback');

    function example_callback($filters)
    {
      return array_merge($filters, [
        'count' => [
          'label'        => __('Filtruj wg "Licznik"', 'lang'),
          'values'       => [
            '1'  => '1',
            '2'  => '2',
            '10' => '10',
          ],
          'action_query' => function($args, $defaultArgs, $value) {
            $args['meta_key']   = 'count';
            $args['meta_value'] = $value;
            return $args;
          },
        ],
        'type' => [
          'label'        => __('Filtruj wg "Typ"', 'lang'),
          'values'       => [
            '1' => [
              'name'   => 'Typ 01',
              'parent' => '0',
            ],
            '2' => [
              'name'   => 'Typ 02',
              'parent' => '1',
            ],
            '10' => [
              'name'   => 'Typ 10',
              'parent' => '0',
            ],
          ],
          'action_query' => function($args, $defaultArgs, $value) {
            $args['meta_key']   = 'type';
            $args['meta_value'] = $value;
            return $args;
          },
        ],
      ]);
    }

Filtr współpracuje jedynie z Post Types. W jego nazwie zamiast `{$slug}` należy podać slug typu postu.

W funkcji zwracamy listę dodatkowych filtrów. Klucz oznacza slug filtra, a wartość to tablica z listą ustawień:

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| label       | string   | domyślna opcja w polu typu select |
| values      | array    | lista dostępnych opcji do wyboru _(klucz oznacza wartość filtra, a wartość etykietę danej opcji)_ |
| action_sort | resource | funkcja pozwalająca filtrować listę postów poprzez zwrócenie argumentów do zmiany w Query _(parametry oznaczają odpowiednio listę argumentów do nadpisania, listę domyślnie użytych argumentów oraz wybraną wartość filtra)_ |

Listę dostępnych argumentów można znaleźć w dokumentacji funkcji `get_posts`. Pełna ich lista znajduje się również [tutaj](https://www.billerickson.net/code/wp_query-arguments/).

> Domyślnie dla każdego Post Type dodawane są automatycznie filtry z taksonomiami do niego podpiętymi. Pozwalają one przefiltrować posty wg wybranej kategorii. W przypadku użycia wielu taksonomii dla jednego Post Type istnieje możliwość łączenia filtrów.

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 7. Ustawienia

## 7.1. Rozmiary obrazków

### Wywołanie

```
$framework->settings->action('images', ${args});
```

### Przykład użycia

```
$framework->settings->action('images', [
  'image-full'   => [
    'width'  => 1920,
    'height' => 1080,
    'crop'   => true,
    'editor' => false,
  ],
  'image-medium' => [
    'width'  => 1000,
    'height' => 1000,
    'crop'   => true,
    'editor' => 'Duże zdjęcie',
  ],
  'image-small'  => [
    'width'  => 500,
    'height' => 500,
    'crop'   => true,
    'editor' => 'Małe zdjęcie',
  ],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| width  | integer          | szerokość w px |
| height | integer          | wysokość w px |
| crop   | boolean          | true oznacza włączenie kadrowania zdjęć do danego rozmiaru |
| editor | string / boolean | nazwa rozmiaru obrazka w edytorze przy dodawaniu zdjęcia _(w przypadku wartości false dany rozmiar nie będzie dostępny)_ |

### Informacje

* jako argumenty przekazujemy tablicę z listą rozmiarów
* jako klucze przekazujemy `slugi` używane potem do pobierania adresu obrazka w danym rozmiarze
* wartości to tablice z argumentami
* domyślne rozmiary obrazków `medium` i `large` są usuwane, dostępny jest tylko rozmiar `thumbnail` oraz własne

[▲ Spis treści](#spis-treści)

&nbsp;

## 7.2. Rejestracja menu

### Wywołanie

```
$framework->settings->action('nav', ${args});
```

### Przykład użycia

```
$framework->settings->action('nav', [
  'top_nav'  => 'Nawigacja górna',
  'main_nav' => 'Nawigacja główna',
]);
```

### Informacje

* jako argumenty przekazujemy tablicę z listą lokalizacji menu
* jako klucze przekazujemy `slugi` używane potem do wyświetlania menu
* wartości to nazwy menu widoczne w panelu administracyjnym
* do pobierania listy menu możesz skorzystać z [helpera](#pobieranie-menu)

[▲ Spis treści](#spis-treści)

&nbsp;

## 7.3. Blokada aktualizacji pluginów

### Wywołanie

```
$framework->settings->action('plugins-update', ${args});
```

### Przykład użycia

```
$framework->settings->action('plugins-update', [
  'contact-form-7' => 'wp-contact-form-7.php',
]);
```

### Informacje

* jako argumenty przekazujemy tablicę z listą pluginów
* jako klucze przekazujemy nazwę folderu, w którym znajduje się plugin
* wartości to nazwy głównych plików pluginów
* dodatkowo poza blokadą aktualizacji ukrywane są wszystkie notyfikacje wyświetlane przez dany plugin

[▲ Spis treści](#spis-treści)

&nbsp;

## 7.4. Konfiguracja bezpieczeństwa

### Wywołanie

```
$framework->settings->action('security', ${args});
```

### Przykład użycia

```
$framework->settings->action('security', [
  'wpc_path_allow' => [
    'wp-content/example.php',
  ],
  'login_url'      => 'my-login',
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| wpc_path_allow | array  | lista ścieżek do plików PHP w katalogu `/wp-content`, do których dostęp powinien być aktywny _(np. wp-content/example.php)_ |
| login_url      | string | nowy adres logowania _(nie należy używać symbolu `/` oraz podawać adresu url na front-endzie)_ |

### `!` Uruchomienie wszystkich funkcjonalności

* podepnij wszystkie pliki i dodaj konfigurację dla sekcji [Konfiguracja bezpieczeństwa](#konfiguracja-bezpieczeństwa)
* zaloguj się do panelu administracyjnego
* przejdź do _Ustawienia_ > _Bezpośrednie odnośniki_
* kliknij przycisk _Zapisz zmiany_
* kroki `należy powtórzyć` po wgraniu gotowej strony na serwer klienta

### Lista funkcji zabezpieczających

* reguły w pliku .htaccess:
  * wyłączenie wyświetlania błędów dla wszystkich plików PHP _(dotyczy bezpośredniego wejścia na plik .php)_
  * blokada możliwości przeglądania listy katalogów
  * zabezpieczenie katalogów:
    * zabezpieczenie katalogu `/wp-admin` oraz `/wp-includes`
    * `*` blokada wykonywania plików PHP w katalogu `/wp-content`
    * blokada dostępu do katalogów przez roboty
  * blokada dostępu do plików _(bez rozróżnienia wielkości znaków)_:
      * `.htaccess`, `.htpasswd`, `.ini`, `.phps`, `.fla`, `.log`, `.sh`, `.bak`, `.git`, `.svn`, `.sql`, `.tar` lub `.tar.gz`
      * `wp-config.php`, `xmlrpc.php`, `install.php`
      * `error_log`, `changelog.txt`, `license.html`, `license.txt`, `license.commercial.txt`, `readme.html`, `readme.md` oraz `readme.txt`
  * blokada adresu zdalnej naprawy bazy danych
  * uniemożliwienie ataku typu URL Haking przy zastosowaniu metod TRACE lub TRACK
  * modyfikacja nagłówków:
      * zabezpieczenie przed atakiem typu Clickjacking
      * zmniejszenie ryzyka ataku typu XSS
      * wyłączanie zgadywania typu MIME strony przez przeglądarki
  * blokada enumeracji użytkowników
* zabezpieczanie samego WordPressa:
  * wyłączenie wyświetlania błędów w PHP podczas korzystania z CMS _(przy wyłączonym trybie debugowania)_
  * automatyczna aktualizacja WordPressa
  * ukrycie wersji WordPressa
  * ukrycie nagłówków WordPressa
  * zmiana domyślnego adresu logowania do panelu administracyjnego
  * limit ilości prób logowania
  * ustawienie własnego komunikatu podczas błędu logowania
  * `*` wyłączenie XML-RPC
  * blokada edycji plików motywu i pluginów
  * blokada nieautoryzowanego dostępu do plików load-scripts.php oraz load-styles.php
  * zabezpieczenie przez atakiem typu SQL Injection
  * ukrywanie informacji pozwalających poznać login użytkownika w REST API
  * zabezpieczenie wyszukiwarki WordPressa przed wysyłaniem zapytań z innej domeny
  * zabezpieczenie przed nieautoryzowanym dodawaniem komentarzy
  * zablokowanie Trackbacks
  * zablokowanie przed atakiem typu Reverse Tabnabbing
* tworzenie logów monitorujących wejścia na stronę

`*` - w specyficznych przypadkach może to powodować problemy z działaniem własnych funkcji, jeżeli zostaną zablokowane ze względów bezpieczeństwa

### Filtry

System blokuje możliwość wejścia na domyślne ścieżki strony logowania _(`/login` oraz `/wp-login.php`)_, umożliwiając autoryzację tylko przy użyciu jednej, zdefiniowanej w kodzie ścieżki. Listę blokowanych ścieżek można modyfikować, usuwając lub dodając nowe, przy użyciu następującego filtra:

```
add_filter('wpf_security_login_paths', 'example_callback', 10, 1);

function example_callback($paths)
{
  // $paths array modifications
  return $paths;
}
```


[▲ Spis treści](#spis-treści)

&nbsp;

## 7.5. Dozwolone typy plików przy uploadzie

### Wywołanie

```
$framework->settings->action('upload', ${args});
```

### Przykład użycia

```
$framework->settings->action('upload', [
  'svg' => 'image/svg+xml',
]);
```

### Informacje

* jako argumenty przekazujemy tablicę z listą typów plików
* jako klucze przekazujemy rozszerzenie plików
* wartości to typy plików
* listę dostępnych typów można znaleźć [tutaj](https://paulund.co.uk/change-wordpress-upload-mime-types)

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 8. Cache strony

### Wywołanie

```
$framework->cache->action('config', ${args});
```

### Przykład użycia

```
$framework->cache->action('config', [
  'timeout'       => 3600,
  'clear_actions' => [
    'save_post',
    'acf/save_post',
    'created_term',
    'edited_terms',
    'delete_term',
  ],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| timeout       | integer | wartość wyrażona w sekundach, oznaczająca co jaki czas powinien się odświeżać cache _(ustaw `0`, aby odświeżać cache przy każdym wejściu na stronę lub `-1`, aby wyłączyć całkiem cache)_ |
| clear_actions | array   | lista [akcji WordPressa](https://codex.wordpress.org/Plugin_API/Action_Reference), przy których będzie wykonywane czyszczenie pamięci cache |

### Informacje

* `!` pamiętaj używając `$_COOKIE` system zrobi kopię strony nie biorąc pod uwagę wartości z tej tablicy, dlatego w kodzie nie powinno być warunków sprawdzających ciasteczko i generujących kod HTML na jej podstawie _(dla tych operacji należy użyć JS lub całkiem wyłączyć cache)_
* system edytuje plik `wp-config.php` dodając do niego wartości `define('WP_CACHE', true);` oraz `define('CACHE_TIMEOUT', ?);` _(tych wartości nie wolno edytować - system generuje je automatycznie na podstawie ustawień z pliku `functions.php`)_
* dodatkowo tworzony jest plik `/wp-content/advanced-cache.php` odpowiadający za inicjację cache przed ładowaniem się WordPressa

### Reguły cache

* serwer inny niż `localhost`
* aktualna strona nie należy do panelu administracyjnego oraz spełnia jeden z warunków: `is_front_page()`, `is_home()`, `is_archive()` lub `is_single()`
* brak elementów w tablicy `$_POST` oraz `$_GET`
* strona odwiedzana przez użytkownika niezalogowanego

### Zasada działania

* brak danej strony w pamięci cache lub wygasły czas ważności:
  * strona jest w całości renderowana
  * kopia kodu HTML zostaje zapisana w ścieżce `/wp-content/cache/`
  * kod HTML strony jest kompresowany _(usuwane są znaki nowej linii, tabulatory oraz wielokrotne spacje)_
* ładowanie strony z pamięci cache:
  * użytkownik błyskawicznie otrzymuje kod HTML
  * następnie PHP kończy połączenie z przeglądarką _(dzięki temu w JS szybciej włączą się funkcje, które potrzebują pełnego załadowania strony)_
  * WordPress zostaje załadowany w tle, co daje możliwość korzystania ze wszystkich funkcji _(np. WP-Cron lub licznik odwiedzin)_
  * czas życia WordPressa zostaje zakończony podczas akcji `get_header` z priorytetem `0`

### Korzyści

* użytkownik otrzymuje kod HTML bez potrzeby oczekiwania na zakończenie renderowania strony
* błąd dotyczący czasu odpowiedzi serwera w narzędzia Google PageSpeed Insights zostaje wyeliminowany _(więcej informacji w sekcji [Wsparcie SEO](#wsparcie-seo))_
* serwer jest mniej obciążany, ponieważ połowa czasu ładowania strony to ładowanie wszystkich elementów silnika WP, pluginów i motywów, a druga połowa to renderowanie samej strony, która w przypadku korzystania z cache się nie wykonuje

### Wyłączenie cache

W specyficznych przypadkach istnieje potrzeba wyłączenia cache dla wybranych osób. Aby to zrobić dla takiej osoby musi zostać utworzone `$_COOKIE`. Następnie należy dodać filtr, w którym zwracamy klucz ciasteczka, np.:

```
add_filter('wpf_cache_logged_cookie', 'example_callback');

function example_callback()
{
  return 'wpf_user_logged_in';
}
```

W tym momencie każdy użytkownik posiadający ciasteczko o kluczu `wpf_user_logged_in` nie będzie korzystał ze strony pobranej z pamięci cache.

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 9. Formularze kontaktowe

## 9.1. Wywołanie

```
$framework->forms->action('load', {$arg});
```

Jako `{$arg}` podajemy wartość boolean _(domyślnie false)_, która oznacza, czy chcemy ładować skrypty Vue.js na każdej podstronie - również tam, gdzie nie ma formularzy. Jest to przydatne w sytuacji, gdy wykorzystujemy Vue.js również do innych celów.

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.2. Zasada działania

System automatycznie tworzy nowy typ postu o slugu `wpf-contact-forms` dla tworzenia własnych formularzy kontaktowych. Dodając go można utworzyć listę pól, a następnie wkleić kod HTML samego formularza. Działa to na podobnej zasadzie, jak w pluginie Contact Form 7 z tą różnicą, że tutaj listę pól dodajemy przy użyciu **ACF Repeater Field**. Również wszystkie pozostałe ustawienia są obsłużone przez plugin **Advanced Custom Fields**.

Dodatkowo w sekcji ustawień Frameworka w panelu administracyjnym dodawana jest sekcja `Contact Forms`, gdzie można ustawić globalne opcje dla formularzy.

Domyślnie frazy widoczne w panelu są napisane w języku angielskim, ale przygotowane jest również tłumaczenie na język polski. Dotyczy to jednak tylko panelu administracyjnego, ponieważ wszystkie komunikaty widoczne dla użytkownika na stronie są edytowalne - można bez problemu nadpisać domyślną wartość, tłumacząc ją na nowy język.

Kod HTML formularza zawiera całą jego strukturę. W miejsach, gdzie mają się znajdować pola należy wkleić shortocodes _(wybrane z listy utworzonych pól)_. Treść komunikatu o błędzie walidacji danego pola jest wyświetlana bezpośrednio pod nim - można dodać własną klasę dla tych elementów. Podobnie jest z komunikatami o pomyślnym wysłaniu formularza lub błędzie przy jego wysyłaniu - z tym wyjątkiem, że miejsce ich lokalizacji wybieramy poprzez wklejenie w wybranym miejscu odpowiednich shortocodes. Wewnątrz kodu HTML można korzystać z warunków i innych kodów Vue.js, ponieważ cały formularz jest komponentem Vue.js.

Sam formularz możemy dodać na stronie wklejając kod implementacji _(podając jako `${arg}` ID formularza - należy pamiętać, że nie wolno podawać w kodzie PHP na sztywno wartości ID)_:

```
<?php do_action('wpf_forms_load', ${arg}); ?>
```

Obsługą formularzy od strony front-endu zajmuje się `Vue.js`, co pozwala na dynamiczną walidację i wysyłanie wiadomości przy użyciu REST API _(endpoint: `/wp-json/wpf/v1/forms/{$id}/`)_. Narzędzie do poprawnego działania wykorzystuje następujące pluginy:
* Vue.js
* VeeValidate
* VueRecaptcha
* Axios

`[!]` - należy pominąć ładowanie powyższych skryptów we własnym zakresie

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.3. Lista wspieranych pól

* Text
* E-mail
* Url
* Telephone
* Number
* Date
* Password
* Textarea
* Select
* Multiselect
* Checkbox
* Radio
* File
* reCAPTCHA
* Agreement
* Hidden

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.4. Walidacja

| Reguła | Wspierane typy pól | Uwagi |
|:--|:--|:--|
| Required        | -               | obowiązkowe dla reCAPTCHA |
| Minimum value   | Number          | - |
| Maximum value   | Number          | - |
| Step value      | Number          | - |
| Date minimum    | Date            | - |
| Date maximum    | Date            | - |
| Minimum length  | Text, Textarea  | - |
| Maximum length  | Text, Textarea  | - |
| File max size   | File            | - |
| File extensions | File            | możliwość zaznaczenia wybranych rozszerzeń z puli ponad 30 opcji |
| E-mail          | E-mail          | automatyczna walidacja |
| Url             | Url             | automatyczna walidacja |
| Date            | Date            | przykładowe formaty dostępne [poniżej](#formaty-daty) |

Walidacja jest realizowana na front-endzie oraz na back-endzie.

Dla każdej z opcji można ustawić własny komunikat o błędzie. Domyślne komunikaty są napisane w języku angielskim oraz polskim, ale na ich bazie można stworzyć własny w innym języku. Dodatkowo należy podać również treści ogólnych komunikatów:
* pomyślne wysłanie formularza
* błąd przy wysyłaniu formularza
* błąd walidacji
* błąd walidacji wybranego pola na back-endzie

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.5. Formaty daty

W polu typu `data` można wybrać różnego typu formaty daty. Oto lista dostępnych wzorów:

| Jednostka      | Wzór    | Przykłady              |
|----------------|---------|------------------------|
| Rok            | yy      | 44, 01, 00, 17         |
|                | yyyy    | 0044, 0001, 1900, 2017 |
| Miesiąc        | M       | 1, 2, ..., 12          |
|                | MM      | 01, 02, ..., 12        |
| Dzień miesiąca | d       | 1, 2, ..., 31          |
|                | dd      | 01, 02, ..., 31        |
| Godzina (1-12) | h       | 1, 2, ..., 11, 12      |
|                | hh      | 01, 02, ..., 11, 12    |
| Godzina (0-23) | H       | 0, 1, 2, ..., 23       |
|                | HH      | 00, 01, 02, ..., 23    |
| Minuta         | m       | 0, 1, ..., 59          |
|                | mm      | 00, 01, ..., 59        |
| AM, PM         | a       | AM, PM                 |
|                | aaaa    | a.m., p.m.             |
|                | aaaaa   | a, p                   |

Dane wzory można ze sobą łączyć i oddzielać dowolnymi znakami, np. spacją, myślnikiem czy przecinkiem. Wszystkie one są kompatybilne z [VeeValidate](https://baianat.github.io/vee-validate/guide/rules.html#date-format).

Przykłady formatów:

| Wzór               | Rezultat            |
|--------------------|---------------------|
| yyyy-MM-dd         | 2019-04-30          |
| HH:mm              | 21:45               |
| yyyy-MM-dd HH:mm   | 2019-04-30 21:45    |
| yyyy-MM-dd hh:mm a | 2019-04-30 09:45 PM |

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.6. Ustawienia formularza

Ustawienia formularzy można dowolnie modyfikować, aby dopasować je do aktualnych potrzeb. Umożliwia to np. na dynamiczne generowanie listy opcji do wyboru _(dla pól typu Select, Multiselect, Checkbox czy Radio)_. W tym celu dostępne jest odpowiednie filtry.

Pamiętaj, aby modyfikując ustawienia zachować oryginalny format danych, ponieważ może to wpłynąć na działanie formularza - najlepiej jest najpierw je dodać na "sztywno", sprawdzić format i dopiero w takim formacie modyfikować wartości dynamicznie.

Oto lista filtrów:

* filtr `wpf_forms_settings` umożliwia zmianę ustawień pól formularza:

  > W funkcji dostępna jest tablica z ustawieniami formularza, a także jego ID.

  ```
  add_filter('wpf_forms_settings_${form_id}', 'example_callback', 10, 2);
  // or
  add_filter('wpf_forms_settings', 'example_callback', 10, 2);

  function example_callback($settings, $formId)
  {
    // $settings array modifications
    return $settings;
  }
  ```

* filtr `wpf_forms_fields` umożliwia zmianę ustawień pól formularza _(wywoływany podczas pobierania pól z bazy danych)_:

  > W funkcji dostępna jest tablica z ustawieniami dodanymi w polach ACF, a także ID formularza.

  ```
  add_filter('wpf_forms_fields_${form_id}', 'example_callback', 10, 2);
  // or
  add_filter('wpf_forms_fields', 'example_callback', 10, 2);

  function example_callback($fields, $formId)
  {
    // $fields array modifications
    return $fields;
  }
  ```

* filtr `wpf_forms_field` umożliwia zmianę ustawień pola formularza _(wywoływany podczas renderowania pola)_:

  > W funkcji dostępna jest tablica z ustawieniami dodanymi w polu ACF, a także ID formularza..

  ```
  add_filter('wpf_forms_field_${form_id}', 'example_callback', 10, 2);
  // or
  add_filter('wpf_forms_field', 'example_callback', 10, 2);

  function example_callback($field, $formId)
  {
    // $field array modifications
    return $field;
  }
  ```

  Jeżeli chcemy np. wyłączyć obowiązek uzupełnienia danego pola, możemy użyć filtra udostępnionego przez plugin ACF _(przykład dla pola “Wartości” używanego w przypadku pól typu Select, Multiselect, Checkbox czy Radio)_:

  ```
  add_filter('acf/load_field/name=values', 'example_callback');

  function example_callback($field)
  {
    if (!is_admin()) return $field;

    global $post;
    if (!$post || ($post->post_type !== 'wpf-contact-forms')) return $field;

    $formId = get_field('events_register_form');
    if ($post->ID !== $formId) return $field;

    $field['required'] = false;
    return $field;
  }
  ```

* filtr `wpf_forms_template` umożliwia zmianę ustawień pól formularza:

  > W funkcji dostępna jest string z szablonem formularza _(przed przetworzeniem przez parser PHP)_, a także ID formularza.

  ```
  add_filter('wpf_forms_template_${form_id}', 'example_callback', 10, 2);
  // or
  add_filter('wpf_forms_template', 'example_callback', 10, 2);

  function example_callback($template, $formId)
  {
    // $template string modifications
    return $template;
  }
  ```

* filtr `wpf_forms_config` umożliwia zmianę konfiguracji formularza _(przekazywanej do klasy JS)_:

  > W funkcji dostępna jest tablica z konfiguracją formularza, a także jego ID.

  ```
  add_filter('wpf_forms_config_${form_id}', 'example_callback', 10, 2);
  // or
  add_filter('wpf_forms_config', 'example_callback', 10, 2);

  function example_callback($config, $formId)
  {
    // $configarray modifications
    return $config;
  }
  ```

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.7. Domyślne wartości

Istnieje możliwość zadeklarowania domyślnych wartości dla pól. Umożliwia to np. wstępne uzupełnianie formularza danymi pobranymi z profilu zalogowanego użytkownika. Pozwala to także na uzupełnienie wartości pola typu `Hidden`, które może być wykorzystywane do przesyłania dodatkowych informacji lub tworzenia niestandardowych kolekcji warunków _(zależnych nie tylko od wartości wpisanych przez użytkownika, ale również np. od strony, na której użytkownik się znajduje)_.

Filtr `wpf_forms_field_value` umożliwia zadeklarowanie domyślnej wartości dla danego pola:

> W funkcji dostępna jest zmienna z wartością pola _(jest to string lub tablica, w zależności od jego typu)_, a także ustawienia pola oraz ID formularza. Filtr nie wspiera pól typu: Checkbox, Radio, File oraz Agreement.

```
add_filter('wpf_forms_field_value', 'example_callback', 10, 3);

function example_callback($value, $field, $formId)
{
  // $value string modifications
  return $value;
}
```

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.8. Kod formularza

Wykorzystując filtry istnieje możliwość modyfikacji kodu HTML formularza. Dzięki temu możemy rozbudować domyślne możliwości Frameworka.

Oto lista filtrów:

* filtr `wpf_forms_form_html` umożliwia modyfikację kodu HTML całego formularza _(pozwala to pełną modyfikację jego struktury)_

  > W funkcji dostępny jest oryginalny kod HTML, który możemy zmodyfikować i następnie zwrócić, a także ID formularza pozwalający na jego identyfikację.

  ```
  add_filter('wpf_forms_form_html_${form_id}', 'example_callback', 10, 2);
  // or
  add_filter('wpf_forms_form_html', 'example_callback', 10, 2);

  function example_callback($html, $formId)
  {
    // $html string modifications
    return $html;
  }
  ```

* filtr `wpf_forms_field_html` umożliwia modyfikację kodu HTML wybranych pól formularza _(pozwala to na dodanie np. własnego data-attribute lub wrappera dla tagu input)_

  > W funkcji dostępny jest oryginalny kod HTML, który możemy zmodyfikować i następnie zwrócić, a także opcje danego pola pozwalające na jego identyfikację i właściwą modyfikację oraz ID formularza.

  ```
  add_filter('wpf_forms_field_html', 'example_callback', 10, 3);

  function example_callback($html, $field, $formId)
  {
    // $html string modifications
    return $html;
  }
  ```

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.9. Wysyłanie formularza

Domyślnym sposobem wysyłki formularzy są wiadomości e-mail. Ich zawartość _(adresata, nadawcę, temat, dodatkowe nagłówki, treść wiadomości)_ można skonfigurować w panelu administracyjnym. W tych polach istnieje możliwość korzystania z shortcode, aby wartości były dynamicznie pobierane z formularza.

Dodatkowo dla każdego z szablonów wiadomości e-mail można zadeklarować kolekcję warunków, która określać będzie, kiedy dany szablon ma zostać użyty. Można dzięki temu stworzyć wiele szablonów i wykorzystywać je w zależności od wartości podanych w formularzu przez użytkownika.

`[?]` Nie zawsze trzeba wysyłać wiadomości e-mail. Framework daje możliwość **wysyłki formularzy również przy użyciu własnej funkcji PHP**. Można to używać zamiennie z e-mailem lub skorzystać z obu opcji dla danego formularza. Funkcja PHP jest wykonywana przed wysłaniem wiadomości e-mail, więc w sytuacji zwrócenia błędu przez tą funkcję, dalsze działania zostaną przerwane.

Dla wysyłki formularzy dostępnych jest kilka filtrów, które umożliwiają spersonalizowanie ich działania:

* filtr `wpf_forms_values` umożliwia modyfikację wartości przesyłanych przez formularz _(pozwala to nie tylko na ich edycję, ale również na dodawanie własnych informacji, jak np. adres IP)_

  > W funkcji dostępny jest domyślny status _(true)_, lista pól wraz z konfiguracją, lista wartości oraz ID formularza.

  ```
  add_filter('wpf_forms_values_${form_id}', 'example_callback', 10, 3);
  // or
  add_filter('wpf_forms_values', 'example_callback', 10, 3);

  function example_callback($values, $fields, $formId)
  {
    // $values array modifications
    return $values;
  }
  ```

* filtr `wpf_forms_validation` umożliwia dodatkową walidację przesyłanych wartości _(pozwala to na tworzenie zaawansowanych typów walidacji takich, jak np. weryfikacja unikalności podanego adresu e-mail - hook uruchamiany jest po przejściu standardowej walidacji)_

  > W funkcji dostępny jest domyślny status _(true)_, lista pól wraz z konfiguracją, lista wartości oraz ID formularza.

  ```
  add_filter('wpf_forms_validation_${form_id}', 'example_callback', 10, 4);
  // or
  add_filter('wpf_forms_validation', 'example_callback', 10, 4);

  function example_callback($status, $fields, $values, $formId)
  {
    // $values array validation
    return $status; // true/false/string
  }
  ```

  Dostępne opcje zwracanych wartości:
  * `true` _(pomyślna walidacja)_
  * `false` _(nieudana walidacja, ogólny komunikat o błędzie)_
  * `string` _(nieudana walidacja, spersonalizowany komunikat o błędzie)_

* filtr `wpf_forms_send` umożliwia integrację formularza z zewnętrznymi systemami oraz przetwarzanie ich w inny niż wysyłanie wiadomości e-mail

  > W funkcji dostępne jest domyślny status _(null, czyli akcja nie dotyczy danego formularza)_, lista pól wraz z konfiguracją, lista wartości oraz ID formularza.

  ```
  add_filter('wpf_forms_send_${form_id}', 'example_callback', 10, 4);
  // or
  add_filter('wpf_forms_send', 'example_callback', 10, 4);

  function example_callback($status, $fields, $values, $formId)
  {
    // integration codes
    return $status; // true/false/string/null
  }
  ```

  Dostępne opcje zwracanych wartości:
  * `true` _(pomyślne wysłanie)_
  * `false` _(nieudana próba wysłania, ogólny komunikat o błędzie)_
  * `string` _(nieudana próba wysłania, spersonalizowany komunikat o błędzie)_

* filtr `wpf_forms_email` umożliwia modyfikację danych używanych do wysyłania wiadomości e-mail _(pozwala to np. na dodanie dodatkowych informacji do treści e-maila, jak adres IP czy modyfikacja adresata wiadomości w zależności od wybranych opcji)_

  > W funkcji dostępna jest tablica z danymi do wysyłania e-maili, którą możemy zmodyfikować i zwrócić, a także lista pól z wartościami oraz ID formularza.

  ```
  add_filter('wpf_forms_email_${form_id}', 'example_callback', 10, 3);
  // or
  add_filter('wpf_forms_email', 'example_callback', 10, 3);

  function example_callback($data, $values, $formId)
  {
    // $data array modifications
    return data;
  }
  ```

* filtr `wpf_forms_response` umożliwia modyfikację odpowiedzi wyświetlanej użytkownikowi po wysłaniu formularza _(pozwala to na wykorzystywanie wielu wersji wiadomości, w zależności od potrzeby)_

  > W funkcji dostępna jest oryginalna wiadomość, którą możemy zmodyfikować i następnie zwrócić, a także status _(true/false)_, kod odpowiedzi HTTP, listę pól formularza, listę wartości podanych w formularzu, listę kolekcji warunków wraz z wartościami _(true/false)_ oraz ID formularza.

  ```
  add_filter('wpf_forms_response_${form_id}', 'example_callback', 10, 7);
  // or
  add_filter('wpf_forms_response', 'example_callback', 10, 7);

  function example_callback($message, $status, $code, $fields, $values, $conditions, $formId)
  {
    // $message string modifications
    return $message;
  }
  ```

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.10. Kolekcje warunków

### Konfiguracja

W dodatkowej zakładce w panelu administracyjnym, podczas edycji formularza mamy możliwość stworzenia własnych kolekcji warunków. Są one przydatne w sytuacji, gdy chcemy np. ukrywać dane pola formularza w zależności od opcji wybranej w innym polu lub gdy konkretny szablon wiadomości e-mail ma zostać własny tylko, gdy wartość danego pola jest określona.

Każda kolekcja warunków zawiera swoje grupy warunków. Logiczną relacją między warunkami w grupie może być `AND` lub `OR`. Relacje między grupami to zawsze `AND`, czyli wszystkie elementy grupy muszą być spełnione, a wewnątrz każdej grupy muszą być spełnione odpowiednio wszystkie lub co najmniej jeden warunek. Kolekcja warunków powinna posiadać unikalną nazwę, którą później należy podawać w innych miejscach.

Poszczególny warunek zawiera unikalną nazwę pola, odpowiednią metodę porównywania wartości podanej przez użytkownika w polu z zadeklarowaną wartością _(do wyboru `==`, `!=`, `<`, `>`, `contains`, `empty`, lub `not empty`)_ oraz zadeklarowana wartość. Powstaje z tego standardowy `if`.

Jako nazwę pola podajemy tą podaną w zakładce `Pola`. Nie można jednak porównywać wartości z wszystkich pól. Należy pamiętać, że część z nich jest zapisana w inny sposób niż jako ciąg znaków _(wyjątkiem są Multiselect i Checkbox, gdzie musimy skorzystać z operatora `contains`)_. Bez problemu korzystać można z następujących typów pól do tych celów:
* Text
* E-mail
* Url
* Telephone
* Number
* Date
* Textarea
* Select
* Multiselect
* Checkbox
* Radio

Globalne deklarowanie kolekcji warunków pozwala wykorzystywać te same reguły w wielu miejscach. Nie ma potrzeby wielokrotnego powielania tych samych ustawień.

### Warunkowe używanie szablonów e-mail

Aby wysłać dany szablon wiadomości e-mail tylko w przypadku spełniania danej kolekcji warunków, należy podać przy jego konfiguracji nazwę kolekcji warunków. Jest to opcjonalne, ale przydaje się w sytuacji, gdy chcemy np. kierować wiadomości do różnych adresatów w zależności od wybranej opcji w danym polu.

Pole do podania nazwy kolekcji warunków pojawia się dopiero wtedy, gdy lista kolekcji warunków zawiera przynajmniej jeden element.

### Ukrywanie pól na front-endzie

Dodatkowa walidacja przydaje się również w przypadku pól na front-endzie. Możemy część z nich ukrywać, gdy kolekcja warunków jest spełniona. Aby to zrobić dodajemy do kontenera, który chcemy ukryć następujący kod:

```
v-hide=”[condition=name]”
```

Parametr `name` oznacza nazwę kolekcji warunków. W tej sytuacji, gdy użytkownik spełni warunki podane w kolekcji, dany kontener i jego zawartość zostaną usunięte. W miejscu shortcode zostanie dodany odpowiedni warunek JS. Walidacja zarządzana przez VeeValidate dla pól umieszczonych w tym kontenerze również nie będzie wyświetlała błędów. Dany shortcode może być użyty wielokrotnie.

Artybut `v-hide` nie jest natywnie wspierany przez Vue.js. Framework zamienia go na postać `v-if` z odwrotnym warunkiem.

Jeżeli parametr `name` będzie błędny lub nieznany to shortocode nie zostanie przetworzony i formularz Vue.js nie będzie działał prawidłowo.

### Wyłączanie walidacji pól

Użycie `v-hide` ukrywa daną część formularza oraz wyłącza walidację front-endową pól wewnątrz. Niemniej walidacja back-endowa cały czas działa. Aby temu zapobiec dla danych pól możemy również podać nazwę kolekcji warunków. W przypadku, gdy jest ona spełniona to walidacja dla danego pola zostaje wyłączona. Pozwala to uniknąć błędów walidacji po stronie back-endu, gdy dane pole jest nieużywane.

Podając nazwę kolekcji warunków wyłączamy również walidację front-endową typu `required` _(pozostałe reguły zostaną zachowane)_. W sytuacji, gdy nie chcemy ukrywać pola, ale dynamicznie wyłączyć wymóg podania w nim wartości _(w sytuacji, gdy np. inne pole jest uzupełnione)_ to możemy to zrobić bez użycia `v-hide` i tym samym bez ukrywania pól. Wystarczy, że wyłączamy walidację front-endową i back-endową.

W tej sytuacji pole stanie się opcjonalne. Jeżeli jednak ktoś wypełni mimo wszystko dane pole to walidacja front-endowa będzie uruchomiona. Back-endowa jest wyłączana w tej sytuacji w pełni _(ze względu na ewentualne błędy walidacji, gdy użytkownik uzupełnił pole, a potem zostało ono ukryte poprzez `v-hide`)_.

Pole do podania nazwy kolekcji warunków pojawia się dopiero wtedy, gdy lista kolekcji warunków zawiera przynajmniej jeden element.

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.11. Dane formularza

Vue.js w zmiennej `$data` przechowuje informacje dotyczące danego formularza:

| Klucz główny | Klucz podrzędny | Informacje |
|:--|:--|:--|
| form     | -                 | _(lista pól formularza wraz z zawartością)_ |
| response | -                 | - |
| -        | submit_error      | zawartość komunikatu o błędzie |
| -        | submit_success    | zawartość komunikatu o pomyślnym wysłaniu formularza |
| status   | -                 | _(zbiór wartości **boolean**)_ |
| -        | errors            | istnieje błąd formularza _(dotyczy błędu walidacji oraz błędu pochodzącego z back-endu)_ |
| -        | errors_validation | istnieje błąd walidacji |
| -        | errors_response   | istnieje błąd pochodzący z back-endu |
| -        | sending           | wysyłanie formularza w trakcie |
| -        | sent              | formularz pomyślnie wysłany |

Główny kontener formularz _(tag form)_ zawiera artybut `data-status`, który może przechowywać następujące wartości _(nie istnieje w przypadku braku wartości)_:
* sending _(trwa wysyłanie formularza)_
* sent _(formularz wysłany poprawnie)_
* errors _(wystąpił błąd walidacji lub wysyłania formularza)_

Można tą informację wykorzystać do uruchomienia za pomocą CSS np. animacji wysyłania albo do ukrycia zawartości formularza po jego wysłaniu. Jest to alternatywa dla eventów JS.

Dodatkowo każde pole posiada atrybut `data-field-type` zawierający typ pola wybrany w panelu administracyjnym. Może on być różny od atrybutu `type`, którego wartość jest ograniczona przez specyfikację HTML i w niektórych przypadkach jest niespójna z wybranym typem pola.

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.12. Eventy w JS

W celu lepszej komunikacji z formularzem przygotowane są eventy pozwalające wywołać wybrane akcji przy danych zdarzeniach:

* event `wpfFormReady` wywoływany jest po zbudowaniu formularza _(wywoływane w trakcie eventu `mounted()`, umożliwia np. uruchomienie akcji na gotowych elementach DOM)_

  > W funkcji dostępna jest zmienna `e.detail.form_id` zawierająca ID formularza, `e.detail.wrapper` przechowująca główny kontener formularza jako element DOM, `e.detail.fields` z listą wartości pól, które pozwalają edytować zawartość formularza z poziomu Twojego kodu JS, `e.detail.status` z wartościami aktualnego statusu formularza oraz `e.detail.config` z domyślną konfiguracją formularza.

  ```
  window.addEventListener('wpfFormReady', (e) => {
    // ...
  })
  ```

* event `wpfFormUpdate` wywoływany jest po odświeżeniu kodu formularza _(wywoływane w trakcie eventu `updated()`, umożliwia np. uruchomienie akcji na gotowych elementach DOM)_

  > W funkcji dostępna jest zmienna `e.detail.form_id` zawierająca ID formularza oraz `e.detail.wrapper` przechowująca główny kontener formularza jako element DOM.

  ```
  window.addEventListener('wpfFormUpdate', (e) => {
    // ...
  })
  ```

* event `wpfFormSendBefore` wywoływany jest przed wysłaniem formularza _(umożliwia np. uruchomienie animacji ładowania na przycisku submit)_

  > W funkcji dostępna jest zmienna `e.detail.form` zawierająca formularz jako element DOM, `e.detail.form_id` z ID formularza oraz `e.detail.data` z wartościami formularza.

  ```
  window.addEventListener('wpfFormSendBefore', (e) => {
    // ...
  })
  ```

  Istnieje możliwość zablokowania akcji wysyłania poprzez dodanie kodu `e.preventDefault();`

* event `wpfFormSendAfter` wywoływany jest przed wysłaniem formularza _(umożliwia np. zatrzymanie animacji ładowania na przycisku submit lub ukrycie formularza po poprawnym jego wysłaniu)_

  > W funkcji dostępna jest zmienna `e.detail.form` zawierająca formularz jako element DOM, `e.detail.form_id` z ID formularza oraz `e.detail.success` ze statusem _(boolean)_.

  ```
  window.addEventListener('wpfFormSendAfter', (e) => {
    // ...
  })
  ```

[▲ Spis treści](#spis-treści)

&nbsp;

## 9.13. Obsługa pól dla plików

Narzędzie wspiera pola typu `file` - również z opcją wyboru wielu plików. Pliki przechowywane są w formie tablicy, więc istnieje możliwość dodania nowych bez usuwania starych oraz usuwanie wybranych z nich. Aby spersonalizować wygląd pola najlepszym rozwiązaniem jest stworzenie kontenera, w którym znajdzie się pole typu file, a następnie ustawić następujące style dla pola:

```
.wrapper {
  position: relative;

  input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
  }
}
```

Dzięki temu otrzymamy dropzone w bardzo prosty sposób. Po przesunięciu pliku na ten obszar lub jego kliknięciu i wybraniu z dysku, dany plik zostanie załączony do formularza. Aby móc wykryć tą akcję należy wykorzystać następujący event:

```
window.addEventListener('wpfFormUploadFiles', (e) => {
  // ...
})
```

W funkcji dostępne są zmienne:
* `e.detail.form_id` _(ID formularza)_
* `e.detail.handle` _(uchwyt instancji Vue.js)_
* `e.detail.input` _(pole input jako element DOM)_
* `e.detail.list` _(lista plików)_

Po podpięciu akcji do odpowiednich przycisków można wywołać funkcję usuwającą wybrane pliki:

```
${handle}.$emit('removeFile', ${inputName}, ${index})
```

Lista argumentów:

| Klucz&nbsp;zmiennej | Opis |
|:--|:--|
| ${handle}    | instancja Vue.js _(uchwyt do niej jest zwracany przez event `wpfFormUploadFiles`)_ |
| ${inputName} | artybut `name` danego pola typu file |
| ${index}     | indeks pliku do usunięcia _(licząc od 0, pozostaw puste, aby usunąć wszystkie pliki)_ |

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 10. Narzędzia

## 10.1. Czyszczenie strony

### Wywołanie

```
$framework->tools->action('cleaner');
```

### Informacje

* narzędzie tworzy widget zawierający przyciski umożliwiające zarządzanie rewizjami oraz automatycznymi szkicami, dając informację o ich ilości oraz możliwość usunięcia ich w dowolnym momencie
* automatyczne usuwane są wszystkie rewizje starsze niż 7 dni _(operacja uruchamiana jest raz dziennie)_

[▲ Spis treści](#spis-treści)

&nbsp;

## 10.2. Statystyki odwiedzin

### Wywołanie

```
$framework->tools->action('stats', ${args});
```

### Przykład użycia

```
$framework->tools->action('stats', [
  'limit_daily'   => 8,
  'limit_monthly' => 12,
  'limit_yearly'  => 10,
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| limit_daily   | integer | limit ostatnich dni do wyświetlania |
| limit_monthly | integer | limit ostatnich miesięcy do wyświetlania |
| limit_yearly  | integer | limit ostatnich lat do wyświetlania |

### Informacje

* system zlicza unikalne wejścia na stronę na podstawie zapisywanych w przeglądarkach użytkownika `cookies` oraz każdorazowe wejścia na stronę
* statystyki są liczone również wtedy, kiedy widget nie jest skonfigurowany
* do zapisywania statystyk system tworzy własną tabelę w bazie danych o nazwie `..._wpf_stats`
* dodatkowo dla każdego pojedynczego postu i strony zapisywana jest wartość postmeta o kluczu `views_count` zawierająca ilość odsłon

[▲ Spis treści](#spis-treści)

&nbsp;

## 10.3. Walidator kategorii

### Wywołanie

```
$framework->tools->action('validate-categories', ${args});
```

### Przykład użycia

```
$framework->tools->action('validate-categories', [
  [
    'slug'        => 'category',
    'post_types'  => ['post'],
    'min_checked' => 1,
    'max_checked' => 1,
  ],
]);
```

### Lista argumentów

| Klucz&nbsp;tablicy | Wartość | Opis |
|:--|:--|:--|
| slug        | string  | slug taksonomii |
| post_types  | string  | slugi typów postów |
| min_checked | integer | minimalna ilość wybranych kategorii _(ustaw `-1`, aby wyłączyć)_ |
| max_checked | integer | maksymalna ilość wybranych kategorii _(ustaw `-1`, aby wyłączyć)_ |

### Informacje

* jako argumenty przekazujemy tablicę z listą taksonomii
* każda tablica danej taksomonii musi zawierać dane wymienione w tabeli powyżej
* jako slug możemy podawać domyślne `category` oraz wszystkie własne taksonomie hierarchiczne _(tagi nie są obsługiwane)_
* walidator w razie wystąpienia błędu wyświetla specjalny pasek z alertem, uniemożliwiając zapisanie niepoprawnego postu

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 11. Moduły wbudowane

## 11.1. Przekierowania 301

### Zarządzanie

```
Panel administracyjny -> WP Framework -> 301 Redirects
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy skonfigurować ten moduł. Mamy możliwość tworzenia własnych przekierowań 301. Pozwoli to uniknąć błędów 404 po wdrożeniu nowego serwisu na obecnej domenie.

Głównym elementem jest pola typu repeater, w którym należy podać listę przekierowań. Każde z nich jest złożone ze starej ścieżki, którą może być również wyrażenie regex oraz ścieżki, na którą nastąpi przekierowanie.

Dla każdego wyrażenia regularnego automatycznie dodawany jest opcjonalnie slash na początku i na jego końcu. Podawanie ich na początku bądź na końcu ścieżki jest opcjonalne. Dotyczy to tylko tzw. starej ścieżki.

[▲ Spis treści](#spis-treści)

&nbsp;

## 11.2. Duplikator

### Zarządzanie

```
Panel administracyjny -> WP Framework -> Duplicator
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy skonfigurować ten moduł. Po jego włączeniu mamy dostęp do wyboru typów postów, w których ma się pojawić możliwość powielania postów _(domyślnie jest uruchomiony dla formularzy)_.

Dla wybranych typów postów dodawany jest link umożliwiający powielenie postu _(jest on widoczny na liście postów)_. Dodatkowo link pojawia się również podczas edycji postu, obok przycisku zapisywania w bocznym panelu. Po jego kliknięciu dodawany jest sklonowany post wraz z taksonomiami oraz kompletem danych. Nowy post zapisywany jest jako szkic, a jego autorem jest użytkownik wykonujący operację powielania.

Link do powielania postu jest widoczny jedynie dla użytkowników posiadających uprawienia `edit_posts`. Proces generowania jest zabezpieczony, aby uniemożliwić nieuprawnione uruchomienie tej operacji.

Wykorzystując tą funkcjonalność nie trzeba korzystać z pluginów do duplikowania postów.

[▲ Spis treści](#spis-treści)

&nbsp;

## 11.3. Integracje

### Zarządzanie

```
Panel administracyjny -> WP Framework -> Integrations
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do konfiguracji każdego z dostępnych systemów.

Narzędzie umożliwia integrację z następującymi systemami:
* Google Analytics
* Google Tag Manager
* Facebook Pixel
* Hotjar
* LiveChat
* Facebook Customer Chat

Integracja polega na umieszczeniu w odpowiednim miejscu kodów instalacyjnych.

[▲ Spis treści](#spis-treści)

&nbsp;

## 11.4. Mapa witryny

### Zarządzanie

```
Panel administracyjny -> WP Framework -> Sitemap
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do wyboru typów postów i taksonomii, które mają się znajdować w mapie witryny.

Główna mapa znajduje się pod adresem: `/sitemap.xml`. Znajdują się w niej linki do mniejszych map, gdzie są wyświetlane elementy z danego typu postu lub taksonomii. Zawartość map nie jest zapisywana, przez co narzędzie nie spowalnia działania serwisu oraz zawsze mamy dostęp do aktualnej wersji. Podział mapy na mniejsze elementy przyspiesza ich generowanie oraz pozwoli łatwiej dotrzeć do interesującej nas treści.

Nie musisz ręcznie zgłaszać mapy do Google, ponieważ system zrobi to automatycznie po zmianie konfiguracji Sitemap.

[▲ Spis treści](#spis-treści)

&nbsp;

## 11.5. Ustawienia e-mail

### Zarządzanie

```
Panel administracyjny -> WP Framework -> PHPMailer
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do konfiguracji danych w PHPMailer.

Domyślnie wysyłka wiadomości e-mail jest zablokowana na hostingu - konfigurując własną skrzynkę wysyłającą jesteśmy w stanie rozwiązać ten problem. Poza samym podaniem potrzebnych danych można również sprawdzić ich poprawność za pomocą testera. Wpisując adres e-mail system wyśle testową wiadomość, wyświetlając przy tym log wykonywanych operacji.

[▲ Spis treści](#spis-treści)

&nbsp;

## 11.6. Ustawienia SEO

### Zarządzanie

```
Panel administracyjny -> WP Framework -> SEO settings
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy uruchomić ten moduł. Po jego włączeniu mamy dostęp do konfiguracji tytułu, opisu oraz obrazka widocznego przy udostępnianiu strony na portalach społecznościowych.

Poziomy ustawień:
* każdy post, strona oraz post z własnych Post Types lub kategoria postu oraz kategoria z własnych Taxonomies
* konfiguracja zdefiniowana dla danego Post Type lub Taxonomy
* konfiguracja domyślna

System szuka informacji możliwie najbardziej szczegółowych - kiedy ich nie ma to dodaje brakujące informacje z niższych poziomów. Wyjątkiem są `title` i `description`, które nie może być dziedziczony z niższego poziomu. Wynika to z tego, że każda podstrona ma swój własny i unikalny tytuł oraz opisu.

Podawanie informacji jest opcjonalne. Warto jednak uzupełnić przynajmniej ustawienia globalne dla całej strony w postaci obrazka.

Lista generowanych tagów w sekcji head:
* title _(opcjonalnie)_
* og:title
* description
* og:description
* og:image
* og:image:width
* og:image:height

[▲ Spis treści](#spis-treści)

&nbsp;

## 11.7. Role użytkowników

### Zarządzanie

```
Panel administracyjny -> WP Framework -> User roles
```

### Zasada działania

Framework automatycznie tworzy nową podstronę w Option Page, na której możemy skonfigurować ten moduł. Mamy możliwość tworzenia własnych ról użytkowników, resetowania istniejących oraz usuwania wybranych z nich.

Tworząc nową rolę mamy możliwość nadania uprawnień dla następujących kategorii:
* Post Types _(uprawienia odnoszące się do domyślnych typów treści: `post`, `page` i `attachment` oraz do własnych)_
* Taxonomies _(uprawienia odnoszące się do domyślnych taksonomii: `category` i `post_tag` oraz do własnych)_
* Options Pages _(uprawienia odnoszące się do podstron `Options Pages`, zarówno tych zadeklarowanych w motywie, jak ich wbudowanych w WordPress Framework)_
* Custom _(lista dostępnych innych uprawnień - należy dodawać je ostrożnie, ponieważ wiele z nich upoważnia do dostępu w wiele różnych obszarów panelu administracyjnego)_
* Languages _(lista języków, dla których będzie dostęp)_

Dodając uprawienia do Post Types należy pamiętać o uprawieniach dla Post Type `attachment`, ponieważ są one wymagane do prawidłowego działania pól ACF obsługujących bibliotekę multimediów.

Wyjaśnienia nazw uprawnień dla grup Post Types oraz Taxonomies:

| Grupa      | Typ                | Uprawnienie            | Opis                                     |
|------------|--------------------|------------------------|------------------------------------------|
| Post Types | post, page, CPT    | create_posts           | Dodawanie postów                         |
| -          | -                  | delete_others_posts    | Usuwanie postów innego autora            |
| -          | -                  | delete_posts           | Usuwanie postów                          |
| -          | -                  | delete_private_posts   | Usuwanie prywatnych postów               |
| -          | -                  | delete_published_posts | Usuwanie opublikowanych postów           |
| -          | -                  | edit_others_posts      | Edycja postów innego autora              |
| -          | -                  | edit_posts             | Przeglądanie / Edycja postów             |
| -          | -                  | edit_private_posts     | Edycja prywatnych postów                 |
| -          | -                  | edit_published_posts   | Edycja opublikowanych postów             |
| -          | -                  | publish_posts          | Publikowanie postów                      |
| -          | -                  | read_private_posts     | Przeglądanie prywatnych postów           |
|            |                    |                        |                                          |
| Post Types | attachment         | upload_files           | Przeglądanie plików / Dodawanie plików   |
| -          | -                  | delete_others_posts    | Usuwanie plików innego autora            |
| -          | -                  | delete_posts           | Usuwanie plików                          |
| -          | -                  | edit_others_posts      | Edycja plików innego autora              |
| -          | -                  | edit_posts             | Edycja plików                            |
|            |                    |                        |                                          |
| Taxonomies | category, post_tag | manage_categories      | Pełne zarządzanie kategoriami            |
|            |                    |                        |                                          |
| Taxonomies | Taxonomy           | manage_terms           | Przeglądanie kategorii                   |
| -          | -                  | edit_terms             | Edycja kategorii                         |
| -          | -                  | delete_terms           | Usuwanie kategorii                       |
| -          | -                  | assign_terms           | Przypisywanie kategorii do postów        |

Należy pamiętać, że część uprawnień jest zależna od innych, np. uprawnienie `edit_others_posts` nie będzie działać bez dodanego uprawnienia `edit_posts`. Zawsze należy w praktyce sprawdzić czy uzyskaliśmy taki poziom uprawnień, jakiego oczekiwaliśmy.

Dla każdego Post Types można ustawić dostęp jedynie do wybranych postów, podając listę ich ID. Wtedy na liście postów danego Post Type w panelu administracyjnym widoczne są tylko wybrane posty. To ustawienie nie daje dostępu do możliwości usuwania tych postów przez użytkownika.

Ograniczając listę języków, do których dostęp ma użytkownik musimy wybrać je z listy. Pozostawiając listę pustą dodajemy dostęp do wszystkich języków. Funkcjonalność współprace z wtyczką Polylang.

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 12. Funkcje pomocnicze

## 12.1. Pobieranie breadcrumbs

### Wywołanie

```
$items = apply_filters('wpf_breadcrumbs', []);
```

### Zasada działania

* funkcja wyświetla breadcrumbsy w formie tablicy
* w każdym elemencie zamieszczony jest adres URL oraz tytuł strony
* pobierana jest zawsze pełna ścieżka do postu lub taksomonii, zawierająca wszystkie kategorie rodziców
* narzędzie jest kompatybilne z pluginem Yoast SEO _(funkcjonalność `primary category`)_
* narzędzie jest kompatybilne z pluginem [WP Better Permalinks](https://wordpress.org/plugins/wp-better-permalinks/)

`[!]` Rejestrując taksomonię pamiętaj, żeby slug ustawić wg wzoru `{posttype}-category`, aby narzędzie mogło pobrać ścieżkę taksomonii prowadzącą do danego postu.

`[?]` Dla strony wyszukiwarki narzędzie automatycznie jako tytuł strony na liście wyświetla `Search Results` - można to przetłumaczyć na inny język używając pluginu Loco Translate lub zmodyfikować tytuł edytując ostatnią pozycję w pobranej liście na stronie `search.php`.

[▲ Spis treści](#spis-treści)

&nbsp;

## 12.2. Wyświetlanie favicons

### Wywołanie

```
do_action('wpf_favicons', ${arg});
```

### Lista argumentów

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg | string | ścieżka do folderu z plikami favicon _(przykład: `/assets/img/favicons/`)_ |

### Zasada działania

* funkcja wyświetla listę tagów HTML odpowiedzialnych za favicons
* lista pobieranych plików jest kompatybilna z generatorem [favicon-generator.org](https://www.favicon-generator.org/)
* dodatkowo narzędzie pobiera wykorzystywaną ścieżkę i dodaje do pliku .htaccess przekierowanie na odpowiedni plik z adresu `/favicon.ico`, dzięki czemu po wejściu np. do panelu administracyjnego będziemy mieli odpowiednią ikonę na karcie

[▲ Spis treści](#spis-treści)

&nbsp;

## 12.3. Pobieranie z Instagrama

### Wywołanie

```
echo apply_filters('wpf_instagram', [], {arg1}, {arg2});
```

### Lista argumentów

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg1 | string | token do autoryzacji _(pobrany np. ze strony: [instagram.pixelunion.net](https://instagram.pixelunion.net/))_ |
| arg2 | string | limit zdjęć do pobranych |

### Zasada działania

* funkcja pobierana żądaną ilość ostatnich zdjęć z konta Instagram
* tablica z wynikami zawiera komplet informacji o każdym ze zdjęć
* zalecane jest cache'owanie pobranych wyników w celu optymalizacji czasu ładowania strony

### Dostępne filtry

Filtr `wpf_instagram_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczym zdjęciu. W funkcji dostępna pod zmienną `$image` jest również oryginalna tablica zwracana przez API Instagrama.

```
add_filter('wpf_instagram_item', 'example_callback', 10, 2);

function example_callback($data, $image)
{
  // $data array modifications
  return $data;
}
```

[▲ Spis treści](#spis-treści)

&nbsp;

## 12.4. Pobieranie listy języków

### Wywołanie

```
$items = apply_filters('wpf_langs', [], ${arg});
```

### Lista argumentów

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg | string | kolumna, wg której ma być posortowana tablica z językami _(do wyboru `slug` lub `title`)_ |

### Zasada działania

* funkcja pobiera listę dostępnych języków w formie tablicy
* tablica dostępna pod kluczem `current` zawiera aktualny język
* w elemencie z kluczem `others` znajduje się lista pozostałych języków, posortowana alfabetycznie

### Dostępne filtry

Filtr `wpf_langs_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczym języku. W funkcji dostępna pod zmienną `$lang` jest również oryginalna tablica zwracana przez plugin Polylang.

```
add_filter('wpf_langs_item', 'example_callback', 10, 2);

function example_callback($data, $lang)
{
  // $data array modifications
  return $data;
}
```

[▲ Spis treści](#spis-treści)

&nbsp;

## 12.5. Pobieranie menu

### Wywołanie

```
$items = apply_filters('wpf_menu', [], ${arg});
```

### Lista argumentów

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg | string | `theme_location` wybranego menu |

### Zasada działania

* funkcja pobiera menu w formie tablicy
* w przypadku stron wykorzystujących plugin Polylang ładowane jest menu dedykowane dla danego języka, a jeżeli takie nie zostało dodane to używane jest menu dla domyślnego języka
* tablice są w sobie zagnieżdżone tworząc schemat drzewa _(zgodnie z tym, jak jest to ułożone w panelu administracyjnym)_
* w każdym elemencie istnieje wartość o kluczu `active`, który informuje czy dany element menu jest aktywny _(zaznacza również wszystkich rodziców)_
* przekazywany obiekt, dostępny pod kluczem `object`, umożliwia pobieranie wartości z ACF _(podajemy go jako drugi argument w funkcji `get_field`)_

### Dostępne filtry

Filtr `wpf_menu_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczym elemencie menu. W funkcji dostępny pod zmienną `$item` jest również oryginalny obiekt menu generowany przez WordPressa oraz  `$location` ze slugiem menu.

```
add_filter('wpf_menu_item', 'example_callback', 10, 3);

function example_callback($data, $item, $location)
{
  // $data array modifications
  return $data;
}
```

Filtr `wpf_menu` umożliwia modyfikację danych zawartych w tablicy `$items`, w której znajdują się wszystkie elementy menu. W funkcji dostępny pod zmienną `$location` jest również slug menu.

```
add_filter('wpf_menu', 'example_callback', 10, 2);

function example_callback($items, $location)
{
  // $items array modifications
  return $items;
}
```

[▲ Spis treści](#spis-treści)

&nbsp;

## 12.6. Pobieranie listy kategorii

### Wywołanie

```
$items = apply_filters('wpf_terms', [], {arg1}, {arg2}, {arg3});
```

### Lista argumentów

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg1 | string | slug wybranej taksonomii |
| arg2 | string | opcjonalnie; slug pola z pluginu ACF wg którego mają być posortowane kategorie _(np. priorytet)_ |
| arg3 | string | opcjonalnie; typ sortowania _(do wyboru `asc` lub `desc`)_ |

### Zasada działania

* funkcja wyświetla kategorie z danej taksonomii w formie tablicy
* tablice są w sobie zagnieżdżone tworząc schemat drzewa _(zgodnie z tym, jak jest to ułożone w panelu administracyjnym)_
* w każdym elemencie istnieje wartość o kluczu `active`, który informuje czy obecnie znajdujemy się na stronie danej kategorii _(zaznacza również wszystkich rodziców)_
* lista pobranych kategorii może być opcjonalnie posortowana wg wartości z pola ACF, a w drugiej kolejności alfabetycznie

### Dostępne filtry

Filtr `wpf_terms` umożliwia modyfikację danych zawartych w tablicy `$items`, w której znajduje się lista kategorii. W funkcji dostępny pod zmienną `$slug` jest również slug taksonomii.

```
add_filter('wpf_terms', 'example_callback', 10, 2);

function example_callback($items, $slug)
{
  // $items array modifications
  return $items;
}
```

Filtr `wpf_terms_item` umożliwia modyfikację danych zawartych w tablicy `$data`, w której znajdują się informacje o pojedynczej kategorii. W funkcji dostępny pod zmienną `$slug` jest również slug taksonomii.

```
add_filter('wpf_terms_item', 'example_callback', 10, 2);

function example_callback($data, $slug)
{
  // $data array modifications
  return $data;
}
```

[▲ Spis treści](#spis-treści)

&nbsp;

## 12.7. Upload plików

### Wywołanie

```
$items = apply_filters('wpf_upload_files', [], {arg1});
```

### Lista argumentów

| Nazwa&nbsp;argumentu | Wartość | Opis |
|:--|:--|:--|
| arg1 | string | klucz plików z tablicy `$_FILES` |

### Zasada działania

* funkcja zapisuje plik lub listę plików w katalogu `wp-uploads`, do właściwej lokalizacji
* przesyłane pliki są kopiowane, a nie przenoszone, więc cały czas są dostępne w katalogu tymczasowym
* nazwa plików zawsze jest unikalna _(w przypadku istnienia pliku o identycznej nazwie, zostanie dodany właściwy przyrostek)_
* dodatkowo dla obrazków są generowane wszystkie rozmiary zdjęć
* pliki są zapisywane jako elementy biblioteki mediów
* jako rezultat zwracana jest tablica ID postów _(w przypadku problemu z danym plikiem zamiast ID jest wartość false)_

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 13. Dodatkowe ustawienia

## 13.1. Przekształcanie tekstu przy zapytaniach Ajax

Korzystając z zapytań Ajax, WordPress automatycznie konwertuje znaki występujące w polach title, content, excerpt oraz wszystkich innych z edytorem TinyMCE przy użyciu funkcji [wptexturize](https://codex.wordpress.org/Function_Reference/wptexturize). Aby wyłączyć to dla wybranej akcji WP Ajax należy dodać następujący kod:

```
add_filter('wpf_ajax_noparse_{action}', '__return_true');
```

`{action}` należy zastąpić wartością `action` przesyłaną metodą GET lub POST.

[▲ Spis treści](#spis-treści)

## 13.2. Filtry do edycji .htaccess

Framework generuje dużą ilość kodu w pliku .htaccess. Większość to funkcje zabezpieczające stronę. W skrajnych przypadkach mogą one powodować konflikt z ustawieniami serwera, więc istnieje możliwość ich wyłączenia.

Oto przykład kodu _(dotyczy wyłączenia obsługi błędów 404)_:
```
add_filter('wpf_htaccess_404', '__return_empty_string');
```

Pamiętaj w sytuacji, gdy budujesz funkcję do modyfikacji zawartości zapisywanej w pliku .htaccess, aby zwracana wartość zawsze była typu `string`.

Lista wszystkich dostępnych filtrów _(argument `$content` zawiera treść wklejaną do pliku .htaccess, którą można zmodyfikować lub usunąć)_:

| Nazwa filtra | Argumenty | Opis |
|:--|:--|:--|
| `wpf_htaccess_404` | `$content` | Wyświetlenie błędu 404 w sytuacji, gdy plik nie istnieje na serwerze. |
| `wpf_htaccess_cron` | `$content` | Usuwanie parametru doing_wp_cron z adresu URL przy włączonym alternatywnym cronie. |
| `wpf_htaccess_favicons` | `$content` | Przekierowanie ścieżki do pliku favicon.ico na ścieżkę w motywie. |
| `wpf_htaccess_redirects_301` | `$content` | Lista przekierowań 301 dodanych w CMS. |
| `wpf_htaccess_security/access_directories` | `$content` | Zablokowanie dostępu do wrażliwych katalogów. |
| `wpf_htaccess_security/access_files` | `$content` | Zablokowanie dostępu do wrażliwych plików. |
| `wpf_htaccess_security/http_headers` | `$content` | Dodanie nagłówków zabezpieczających stronę. |
| `wpf_htaccess_security/indexes` | `$content` | Zablokowanie listowania zawartości katalogów. |
| `wpf_htaccess_security/load_scripts_styles` | `$content` | Zabezpieczenie przed atakami typu DOS. |
| `wpf_htaccess_security/maint_repair` | `$content` | Zablokowanie dostępu do narzędzia naprawy uszkodzonych tabel w bazie danych. |
| `wpf_htaccess_security/php_errors` | `$content` | Wyłączenie wyświetlania błędów w PHP. |
| `wpf_htaccess_security/url_hacking` | `$content` | Zabezpieczenie przed atakami typu URL Hacking. |
| `wpf_htaccess_security/user_enumeration` | `$content` | Blokowanie enumeracji użytkowników. |
| `wpf_htaccess_seo/cache_control` | `$content` | Ustawienie nagłówków umożliwiających cache plików. |
| `wpf_htaccess_seo/redirect_host` | `$content` | Przekierowanie na prawidłowy adres hosta _(https lub http oraz z prefixem www. lub bez)_. |

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 14. Wsparcie SEO

* przekierowanie na prawidłowy adres hosta _(zawierający https lub http oraz z prefixem www. lub bez - zapobiega to duplikowaniu adresów strony)_
* przekierowanie z `index.php` oraz `index.html` na adres zakończony `/`
* dodawanie symbolu `/` na końcu adresu URL _(z wyjątkiem adresów ze zmienną $_GET)_
* automatyczne przekierowanie ze strony załącznika na stronę postu
* blokada indeksacji stron wyników wyszukiwania dla robotów
* ustawieniu odpowiednich nagłówków HTTP dla plików w pliku `.htaccess` _(działa również na home.pl, wyłączone dla serwera localhost)_
* przeniesienie ładowania pliku CSS dla Contact Form 7 z sekcji head na dół strony
* wklejenie zawartości lokalnych plików CSS bezpośrednio w sekcji head _(opcjonalnie; zastępuje ładowanie plików CSS opóźniających renderowanie strony)_

`!` Dzięki powyższym funkcjonalnością oraz włączaniu korzystania z pamięci cache _(zakładając, że nie korzystamy z zewnętrznych plików JS, które nie są ładowane asynchronicznie)_, jesteśmy w stanie `osiągnąć wynik 100/100` w Google PageSpeed Insights.

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

# 15. Użyteczności

## 15.1. Ogólne

* dodawanie zmiennej `wpF.ajaxurl` w JS z adresem URL dla [WP AJAX](https://codex.wordpress.org/Plugin_API/Action_Reference/wp_ajax_(action))
* blokada domyślnego przekierowania na port 80, umożliwiająca działanie BrowserSync _(jeżeli zmienna `WP_DEBUG` w pliku wp-config.php ustawiona jest na true)_
* usuwanie parametru `doing_wp_cron` z adresu URL przy włączonym alternatywnym cronie
* automatyczne przekierowanie na protokół HTTPS, jeżeli w adresie strony jest on wykorzystywany
* automatyczne wyświetlanie tagu `<title>` w sekcji head
* wyświetlenie błędu 404 w sytuacji, gdy plik nie istnieje na serwerze
* przesunięcie `admin bar` na dolną krawędź okna oraz możliwość rozwijania/ukrywania jego zawartości _(domyślnie widoczna jest tylko ikona WP umożliwiająca rozwinięcie paska)_
* wykluczenie katalogów przy tworzeniu kopii zapasowej w pluginie `All-in-One WP Migration`:
  * /wp-content/cache/
  * /wp-content/logs/
  * /wp-content/themes/<YOUR-THEME-NAME>/
* wyłączenie wysyłania wiadomości e-mail po pomyślnie wykonanej automatycznej aktualizacji WordPressa

[▲ Spis treści](#spis-treści)

&nbsp;

## 15.2. W panelu administracyjnym

* blokada modyfikacji drzewa kategorii po wybieraniu elementów podczas edycji postów _(dzięki temu zawsze zachowujemy formę drzewa kategorii)_
* wyłączenie obsługi komentarzy dla stron
* automatyczne przekierowanie na domyślny język w sytuacji braku aktywnego języka _(dotyczy pluginu `Polylang`; zablokowane na stronach z listą postów)_
* pływający boks umożliwiający zapis postu bez przewijania na początek strony _(wraz z automatycznym przescrollowaniem do poprzedniej pozycji po zapisaniu postu)_
* dodanie pozycji w menu ze skrótami do edycji Strony głównej, Menu oraz Tłumaczenia motywu
* wyłączenie ukrywania boksów _(z sekcji `Dodaj element menu`)_ na stronie zarządzania menu `/nav-menus.php`

[▲ Spis treści](#spis-treści)

&nbsp;

## 15.3. Dla tłumaczenia

* ustawianie katalogu `/langs` dla plików językowych _(utworzenie go, jeśli nie istnieje)_
* ustawienie slugu `lang` dla wszystkich funkcji językowych i18n

[▲ Spis treści](#spis-treści)

&nbsp;

## 15.4. Dla ACF

* uruchomienie `Local JSON` i zapisywanie grup z polami w katalogu `acf-json`, w celu przyspieszenia działania strony oraz możliwości wersjonowania listy pól w repozytorium
* dodanie do wyników pobieranych przez Ajax w polu typu `Link` adresów URL archiwów typów postów oraz kategorii
* automatyczne zwijanie wewnętrznych pól w polach `Flexible Content` _(podczas edycji grupy pól)_
* automatycznie zwijanie szablonów w polu `Flexible Content` _(wyłączone przy odświeżaniu strony pod zapisaniu postu)_
* dodanie prefixu `[Options Page]` przed nazwą grupy pól ACF na liście grup, która są przeznaczone dla Options Page
* blokada tłumaczenia podczas edycji grupy pól ACF _(m.in. nazwy pól nie są tłumaczone, np. `Flexible Content`  na `Elastyczne treść`)_
* edycja istniejących reguł lokalizacji grup pól ACF:
  * Page Type = Front Page _(obsługa tłumaczeń przy użyciu pluginu Polylang)_
* dodanie własnych reguł lokalizacji grup pól ACF:
  * Menu depth level
* możliwość ograniczenia wysokości TinyMCE dla pola `Wysiwyg`
* oznaczenie najpopularniejszych layoutów w polu `Flexible Content` _(podczas wybierania sekcji oznaczonych jest 7 najpopularniejszych sekcji, które były wykorzystane min. 10 razy)_

[▲ Spis treści](#spis-treści)

&nbsp;

## 15.5. Dla Yoast SEO

* zmiana priorytetu widgetu Yoast SEO na `low`, aby zawsze znajdował się na dole strony edycji
* usunięcie kolumn z informacjami Yoast SEO na liście postów
* ukrycie rozwijanych list do filtrowania postów na podstawie informacji Yoast SEO
* usunięcie ról użytkowników generowanych przez plugin
* usunięcie z mapy witryny załączników

[▲ Spis treści](#spis-treści)

&nbsp;

&nbsp;

> © 2018-2023 [Jootbox](mailto:hello@jootbox.eu). `All rights reserved.`
