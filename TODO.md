
## EVENT

Afficher tout les résultat à partir du jour courant par défaut DONE

## mapView

Icon par défault pour production et préparation => ferme 
 pour les autres => magasin DONE

## Moulinette produit / code NAF
LOAD DATA INFILE '/var/lib/mysql-files/cet_produit.csv'
INTO TABLE cet_produit
FIELDS TERMINATED BY ';'
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

https://www.insee.fr/fr/metadonnees/nafr2/consultation POST 
{
    "q": "produit",
    "start": 0,
    "rows": 100,
    "facetsQuery": [],
    "filters": []
} 

res = {
    documents:[
        code: code NAF
    ]
}

## Recherche par produit

Lier une liste de produit au deux premier niveau du code NAF de production

## Mise à jour de la prod

Une fois la recherche à jour sur les produits.