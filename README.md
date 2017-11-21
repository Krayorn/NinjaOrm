## Installation

1. Clonez le projet sur votre machine et placez vous dans le dossier **NinjaOrm/**.

```
git clone git@github.com:Krayorn/NinjaOrm.git
cd NinjaOrm/
```
2. Lancez la commande ```composer install``` pour pouvoir utiliser l'autoload.

3. Modifiez le fichier **db.php** avec les informations de votre base de données.

4. Déplacez le fichier generate_model.php à la racine du projet puis lancer la commande ```php generate_model.php``` afin de créer automatiquement les Entités liées à votre base de données.

5. Pour finir, indiquez dans le fichier **db.php** les relations entre vos différentes entités sous la forme One To Many, en précisant bien la colonne liant les deux entités.

```
EntityName::has(['EntityName' => 'ColumnName']);
Film::has(['Seance' => 'film_id']);
```

## Exemples d'utilisation

Pour commencer à utiliser l'ORM et vous familiariser avec les méthodes, vous pouvez importez la base de données **ninjaOrm.sql** fournie dans le dossier exemple.

Pour tester les exemples, déplacez simplement les fichiers que vous voulez tester à la racine du projet puis faites ```php nomDuFichier.php```.
Certains fichiers peuvent nécessiter que vous rajoutier certains arguments avec la commande comme par exemple :
```
php create_film.php "YourNewMovie" "2017-05-05" "An Amazing Director"
```

## Les Logs

Les requêtes et erreurs sont stockées dans le dossier **logs**.

Pensez à les utiliser pour vérifier les requêtes réalisées, le temps d'éxécution de la requête et ses paramètres.

## Les Méthodes

### Méthodes du Manager

Voici une liste de toutes les méthodes que vous pouvez utiliser sur le Manager, elles vous permettent surtout de mettre en place votre environnement et d'ouvrir une connection à la base de données.

Cette méthode vous permet de récuperer une instance du Manager

    // static -- no params
    Manager::getInstance();

Cette méthode vous permet de vous connecter à votre base de données.

    // $conn représente votre tableau de parametres
    $manager->addConnection($conn);


Cette méthode genère automatiquement des Entités représentant les différentes tables de votre base de données.

    // -- no params
    $manager->generateModels()

### Méthodes du Model

Vous pouvez appeller ces méthodes sur toutes les classes qui ```extends``` Model.php.

Pour les trois méthodes statiques suivantes, n'oubliez pas de réaliser un ->make(); pour valider votre requête apres avoir l'avoire construite a l'aide du QuerBuilder. Elles seront probablement appellés lorsque vous n'avez pas l'objet sous la main.

Cette méthode instancie le queryBuilder en mode *Select*, vous permettant de construire votre requête avec plus de paramètres avant d'effectuer cette derniere.

    // static -- no params
    $res = Class::find()->make();

Cette méthode instancie le queryBuilder en mode *Update*, vous permettant de construire votre requête avec plus de paramètres avant d'effectuer cette derniere.

    // static -- $data est un tableau ayant pour clé les noms des colonnes et pour value valeures a inserer dans ces colonnes.
    Class::set($data)->make();

Cette méthode instancie le queryBuilder en mode *Delete*, vous permettant de construire votre requête avec plus de paramètres avant d'effectuer cette derniere.

    // static -- no params
    Class::remove()->make();

Si vous disposez de l'objet que vous souhaitez Insérer / Modifier / Supprimer, utilisez plutôt les méthodes suivantes. Attention : Pour pouvoir être utiliser ces méthodes ont besoin que l'id de l'objet soit bien défini.

Cette méthode supprime en base l'entrée correspondante à l'objet sur lequel elle est effectuée.

    // -- no params
    $Class->delete();

Cette méthode supprime en base l'entrée correspondante à l'objet sur lequel elle est effectuée et toutes les entrée des entitées appartenant a cet objet (Que vous avez précisé dans le **db.php** avec la méthode ***has***).

    // -- no params
    $Class->deleteAll();

Cette méthode insère en base l'entrée correspondante à l'objet sur lequel elle est effectuée si cette dernière n'a pas d'id, si l'objet a un id défini, cette méthode va à la place éditer l'entrée correspondante.

    // -- no params
    $Class->save();

Cette méthode effecute un *->save* sur l'objet ciblé, et toutes les entitées appartenant à ce dernier.

    // -- no params
    $Class->saveAll();

### Méthodes du QueryBuilder

    Ces méthodes vous permettent de customiser vos requêtes après avoir crée une instance du QueryBuilder à l'aide des méthodes Class::find(), Class::set() ou Class::remove().

Cette méthode ne devrait pas être utilisé en indiquant tous ces parametres, elle est disponible surtout dans le cas ou on souhaiterai uniquement faire une recherche sur une seule valeure ou utiliser les valeures par défault, si vous souhaitez modifier son paramètre $insideOperator, utilisez plutôt ->whereOr() ou ->whereAnd()

    // $data est un tableau contenant en clé la colonne ou comparer la valeur donnée en value.
    // $sign représente le comparateur
    // $externOperator répresente la manière de lier le bloc de ce where avec les précedents
    / $insideOperator représente la maniere de lier les différents elements de ce même where
    $QueryBuilder->where($data, $sign = '=', $externOperator = 'OR', $insideOperator = 'AND');

Cette méthode simplifie l'utilisation de where, et doit être utilisé lorsque l'on souhaite avoir le mot clé AND pour séparer les différentes conditions internes de ce bloc

    // Voir where pour des informations sur les paramètres
    $QueryBuilder->whereAnd($data, $sign = '=', $externOperator = 'OR')

Cette méthode simplifie l'utilisation de where, et doit être utilisé lorsque l'on souhaite avoir le mot clé OR pour séparer les différentes conditions de ce bloc

    // Voir where pour des informations sur les paramètres
    $QueryBuilder->whereOr($data, $sign = '=', $externOperator = 'AND')

Cette méthode permet d'ajouter un ORDER BY DESC à votre requête SQL

    // $columnsName représente le nom de la colonne qu'on souhaite utiliser pour réaliser le tri
    $QueryBuilder->orderDesc($columnsName)

Cette méthode permet d'ajouter un ORDER BY ASC à votre requête SQL

    // $columnsName représente le nom de la colonne qu'on souhaite utiliser pour réaliser le tri
    $QueryBuilder->orderAsc($columnsName)


Cette méthode permet de définir les valeures a modifiez lors d'un Update

    // $data est un tableau ayant pour clé les noms des colonnes et pour value valeures a inserer dans ces colonnes.
    $QueryBuilder->set($data)

Cette méthode effectue la requête préparée par cette instance du QueryBuilder

    // -- no params
    $QueryBuilder->make()
