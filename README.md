# Laravel Filter
Le package Laravel Filter permet d'ajouter des filtres au requêtes de type SELECT en
base de données. Les filtres se basent sur la requête effectuée par l'utilisateur.

## Installation

````
composer require dfevrier/laravel-filter
````

## Import

````
class ExampleController extends Controller
{

    use Dfevrier\LaravelFilter\Filter;
}
````

## Utilisation

### Utilisation basique

Par défaut, le recherche s'effectuera sur une égalité.

````
Use App\User;

class UserController extends Controller
{

    use Dfevrier\LaravelFilter\Filter;

    public function index(Request $request)
    {
        $user = new User();
        $user = $this->filter($user, ['city', 'name'], $request);
        $user->get();
        ...
    }
}
````

Le code précédent équivaut au code suivant

````
Use App\User;

class UserController extends Controller
{

    public function index(Request $request)
    {
        User::where('city', '=', $request->get('city'))
            ->where('name', "=", $request->get('name'))
            ->get();
        ...
    }
}
````

### Modifier l'opérateur

En reprenant l'exemple précédent, il est possible de modifier l'opérateur de la recherche.

````
$user = $this->filter($user, ['city' => 'like', 'name'], $request);
````

Le code précédent équivaut au code suivant

````
User::where('city', 'like', '%'.$request->get('city').'%')
    ->where('name', '=', $request->get('name'));
````
