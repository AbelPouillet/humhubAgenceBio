
## EVENT

Afficher tout les résultat à partir du jour courant par défaut DONE

## mapView

Icon par défault pour production et préparation => ferme 
 pour les autres => magasin DONE

## Moulinette produit / code NAF

code retenu :
01 02 03
10 11 
46 47 
52 56
 
légume: 01

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

Lier une liste de produit au deux premier niveau du code NAF de production DONE

Si pas de hightlight message résultat par extension. DONE

## Recherche privilégier productions à produits

R&D ZendLuceneSearch DONE

ajouter les code naf en searchable DONE

## Mapping codeNaf => types

codeNaf Entite + codeNaf Production ==>> typesEntites => typescodeNafNiv2
remplir la db 
+ moulinettes
recherche par type
producteur (01 / 02 / 10 / 11 / 20)
commerçant (46 / 47)
restaurant (56) DONE  

## TODO map les code naf textuels à leur code

Dans la fonction load DONE

Préparer les données pour la prod, 


## Mise à jour de la prod DONE

Une fois la recherche à jour sur les produits.

## Details Entite

## Moulinnette données cetcal vers humhubAgenceBio

## AdminCrud 

## fonctionnalités manquantes

## Moulinnette trie locale provenance des produits