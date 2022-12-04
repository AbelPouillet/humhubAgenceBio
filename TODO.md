
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

code non gérer par nos type :
84.11 
 82.19 
   GP.Légumes
  GP.Préparations.à.base.de.fruits.et.légumes 
 4941B 
   GP.Boulangerie-pâtisserie.et.pâtes.alimentaires
  GP.Boissons.(hors.jus) 
   GP.Viticulture
 6420Z 
   GP.Fruits
 75.00Z 
 7010 
   GP.Produits.d'épicerie
  82.92Z 
   49.41A
 52.10 
   52.10.19
   74.90B
  GP.Commerce.de.détail
  7120B
   68.20B
 85.32Z 
  GP.Autres.produits.transformés 
 8810C 
 71.12B 
 6831Z 
  72.11Z
 49.41C 
 6820B 
   GP.Services.et.traitements.primaires
  70.22Z
  88.99B
  .SGP.Céréales 
 96.09Z 
 62.01Z 
  GP.Produits.laitiers.SGP.Glaces.et.sorbets 
 55.10Z 
 5911C 
 9499Z 
 64.20Z 
 86.21Z 
 8292Z 
  GP.Stockage 
  GP.Aquaculture.et.récolte.de.sel 
 68.31Z 
 70.10Z 
 82.99Z 
  86.90D
  .SGP.Autres.semences 
  GP.Commerce.de.gros 
   52.10.11
  52.29B
 8411Z 
 7490B 
  94.99Z
  GP.Bovins.SGP.Bovins.viande 
 49.41B 
 21.20Z  
  81.30Z
 69.10Z 
   GP.Grandes.Cultures
 86.90E et 0113Z 
  43.21A
 87.90A 
 72.19Z 
 93.29Z 
  ACT.Distribution 
  .S.à.feuilles.ou.tiges 
  .S.à.fruits 
   .S.à.racine,.à.bulbe.ou.à.tubercules
  GP.Plantes.à.parfums,.aromatiques.et.médicinales.et.plantes.à.boissons.SGP.Plantes.à.parfum.et.médicinales 
  GP.Plantes.à.parfums,.aromatiques.et.médicinales.et.plantes.à.boissons.SGP.Épices.et.herbes.fraîches 
 16.24Z 
 68.32A 
 66.30Z 
  GP.Restauration 
 85.51Z 
   GP.Semences.et.plants
  GP.Plantes.à.parfums,.aromatiques.et.médicinales.et.plantes.à.boissons 
 00.00Z 
 87.10B 
 85.59A 
 71.11Z 
 86.90F 
  GP.Ovins.SGP.Ovins.Viande 
 81.21Z 
  GP.Compléments.alimentaires 
  .SGP.Plants 

## Mise à jour de la prod

Une fois la recherche à jour sur les produits.