## AdminCrud Moulinnette d'import

Modifier la réatribution des types pour les entité AgenceBio Uniquement DONE

Ne détruit pas les données supplémentaires (relecture de la moulinnette profiter pour la commenter) DONE

Ajouter la date de la mis à jour des entite DONE

## AdminCrud Crud

Ajouter la date de la mis à jour des entite DONE

## fonctionnalités manquantes
# Newsletter 
création de la newsletter à partir des évènements DONE
STYLE de la newsletter
  

## Moulinnette trie locale provenance des produits

## Moulinette de test de doublon
  Ajouter le champ provenance dans la table cet_production_has_cet_entite et nettoyer en fonction les production à la MAJ AgenceBio .
  liste des produit non trouver:
  autre,Coings,purins de plante (consoude, prêle, ortie),batavia,butternut,courgette,potiron,agneau,mouton,batvia,bette à carde,radis noir,roquette,topinambour,kiwano,cassis,mûres,frisée,potimarron,citrouille,frisée,roquette,scarole,mellifères,vivaces


  supprimer les lettre précédent les code naf dans cet_naf_produit
tester TOUT les champs pouvant identifier un doublons

tester les conflits entre les entite cet et agencebio

## Moulinnette import producteur Cetcal
Tester les doublon et les non certifier
Vérifier par le siret si le producteur est éxistant {
    compléter l'entite Agence bio avec les données cetcal
}
## DOCUMENTATION
# compléter la doc 

## Accueuil agenda

## Sauvegarder les modification impacter par les MAJ humhub


## Recherche HumHub

retirer le picker Catégorie DONE

renommer cetEntité en Annuaire avec carte Done

ajouter Annuaire tableau Done

Retirer le titre Résultat sur la map DONE

Mettre en prod une fois finit 

Mapping Produit => Production pour attribuer les code naf (Utiliser la table cet_naf_produit)

## Optimiser la recherche
["buildQueryTime"]=> float(0.20901489257812) [0]=> array(1) { ["FindTime"]=> float(119.31021380424) } [1]=> array(1) { ["paginationTime"]=> float(0.016572952270508) 
Tester sur les boost des champs

Comparer les recherche sur les searchattribute et sur les métadata

métadata 1 element :
["buildQueryTime"]=> float(0.23794007301331) [0]=> array(1) { ["FindTime"]=> float(0.26938796043396) } [1]=> array(1) { ["paginationTime"]=> float(0.06800389289856)

searchattribute 1 mot :
{ ["buildQueryTime"]=> float(0.10442805290222) [0]=> array(1) { ["FindTime"]=> float(2.801882982254) } [1]=> array(1) { ["paginationTime"]=> float(0.067495107650757) }

métadata 2 élément :
["buildQueryTime"]=> float(0.22120094299316) [0]=> array(1) { ["FindTime"]=> float(0.25035095214844) } [1]=> array(1) { ["paginationTime"]=> float(0.061307907104492)

searchattribute 2 mot:
 ["buildQueryTime"]=> float(0.11404395103455) [0]=> array(1) { ["FindTime"]=> float(4.2952630519867) } [1]=> array(1) { ["paginationTime"]=> float(0.069988965988159) 

 métadata 1 (simple) searchattribute  1 :
 ["buildQueryTime"]=> float(0.1328911781311) [0]=> array(1) { ["FindTime"]=> float(2.2079019546509) } [1]=> array(1) { ["paginationTime"]=> float(0.03964900970459)
métadata 1 (simple) searchattribute 1 aprés améliorations:
 ["buildQueryTime"]=> float(0.29555487632751) [0]=> array(1) { ["FindTime"]=> float(2.7675430774689) } [1]=> array(1) { ["paginationTime"]=> float(0.081161022186279)

 searchattribute 6 :
 ["buildQueryTime"]=> float(0.10953283309937) [0]=> array(1) { ["FindTime"]=> float(13.204768896103) } [1]=> array(1) { ["paginationTime"]=> float(0.055170774459839)

 métadata distance 1 :
  ["buildQueryTime"]=> float(0.22412109375) [0]=> array(1) { ["FindTime"]=> float(35.983824014664) } [1]=> array(1) { ["paginationTime"]=> float(0.063143014907837) 

  métadata distance 1 avec espace:
  ["buildQueryTime"]=> float(0.22899603843689) [0]=> array(1) { ["FindTime"]=> float(45.87987112999) } [1]=> array(1) { ["paginationTime"]=> float(0.062144994735718)

métadata distance 1 avec métadata séparer par distance :
["buildQueryTime"]=> float(0.23546695709229) [0]=> array(1) { ["FindTime"]=> float(5.3314919471741) } [1]=> array(1) { ["paginationTime"]=> float(0.064028024673462)

Tester les attributes en keyword au lieu de Text:
  Text:
{ ["buildQueryTime"]=> float(0.10442805290222) [0]=> array(1) { ["FindTime"]=> float(2.801882982254) } [1]=> array(1) { ["paginationTime"]=> float(0.067495107650757) }
  keyword:
   ["buildQueryTime"]=> float(0.10705018043518) [0]=> array(1) { ["FindTime"]=> float(3.2817900180817) } [1]=> array(1) { ["paginationTime"]=> float(0.064783096313477) } 
   keyword un poil plus long
Tester sans les champs productions et produits:
  avec:
  { ["buildQueryTime"]=> float(0.10442805290222) [0]=> array(1) { ["FindTime"]=> float(2.801882982254) } [1]=> array(1) { ["paginationTime"]=> float(0.067495107650757) }
  sans:
  { ["buildQueryTime"]=> float(0.11326289176941) [0]=> array(1) { ["FindTime"]=> float(1.8907749652863) } [1]=> array(1) { ["paginationTime"]=> float(0.015825986862183) } }
Tester en divisant le champ produit en produits et codeNaf:
  naf et produit dans le même champ:
  { ["buildQueryTime"]=> float(0.10442805290222) [0]=> array(1) { ["FindTime"]=> float(2.801882982254) } [1]=> array(1) { ["paginationTime"]=> float(0.067495107650757) }
  naf et produit séparer :
  ["buildQueryTime"]=> float(0.11384201049805) [0]=> array(1) { ["FindTime"]=> float(1.8832459449768) } [1]=> array(1) { ["paginationTime"]=> float(0.060989141464233)

test searchattribute 1 et distance 1 :
["buildQueryTime"]=> float(0.34627914428711) [0]=> array(1) { ["FindTime"]=> float(8.4321608543396) } [1]=> array(1) { ["paginationTime"]=> float(0.080357789993286)

test searchattribute 2 :
["buildQueryTime"]=> float(0.15651702880859) [0]=> array(1) { ["FindTime"]=> float(4.295156955719) } [1]=> array(1) { ["paginationTime"]=> float(0.086230039596558) 