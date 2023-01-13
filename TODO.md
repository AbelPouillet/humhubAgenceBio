
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


## Moulinnette données cetcal vers humhubAgenceBio
 DONE
## AdminCrud 

Faire Les types à la suite de la mise à jour .

## fonctionnalités manquantes

## Moulinnette trie locale provenance des produits

## Intégration lieux de vente map

Modifier le wall pour les lieux de vente

Modifier le détail pour les lieux de ventes

Mis en prod vendredi 11 h
## Optimiser la recherche