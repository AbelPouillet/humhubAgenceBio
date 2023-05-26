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


## Appeler la recherche qu'une fois

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

## Recherche par distances mesures:

10 km:
array(3) { ["buildQueryTime"]=> float(0.21249985694885) [0]=> array(1) { ["FindTime"]=> float(0.94003701210022) } [1]=> array(1) { ["paginationTime"]=> float(0.065561056137085) } } array(3) { ["buildQueryTime"]=> float(0.0051510334014893) [0]=> array(1) { ["FindTime"]=> float(0.22027087211609) } [1]=> array(1) { ["paginationTime"]=> float(0.41987109184265) } }

40 km:
array(3) { ["buildQueryTime"]=> float(0.21178197860718) [0]=> array(1) { ["FindTime"]=> float(93.482742071152) } [1]=> array(1) { ["paginationTime"]=> float(0.057512044906616) } } array(3) { ["buildQueryTime"]=> float(0.0054671764373779) [0]=> array(1) { ["FindTime"]=> float(90.336533069611) } [1]=> array(1) { ["paginationTime"]=> float(1.7961437702179) } }

## Mieux Séparer les distances par zones :

10 km:
array(3) { ["buildQueryTime"]=> float(0.16496109962463) [0]=> array(1) { ["FindTime"]=> float(0.76763701438904) } [1]=> array(1) { ["paginationTime"]=> float(0.033241033554077) } }

20km:
{ ["buildQueryTime"]=> float(0.19296097755432) [0]=> array(1) { ["FindTime"]=> float(2.7879438400269) } [1]=> array(1) { ["paginationTime"]=> float(0.052726030349731) } }

30km:
 { ["buildQueryTime"]=> float(0.22730302810669) [0]=> array(1) { ["FindTime"]=> float(14.151912927628) } [1]=> array(1) { ["paginationTime"]=> float(0.056056022644043) } }

40 km:
array(3) { ["buildQueryTime"]=> float(0.19741916656494) [0]=> array(1) { ["FindTime"]=> float(30.138770103455) } [1]=> array(1) { ["paginationTime"]=> float(0.059139966964722) } }

## Recherche par coordonnées :

10 km:
{ ["buildQueryTime"]=> float(0.21149110794067) [0]=> array(1) { ["FindTime"]=> float(2.9463529586792) } [1]=> array(1) { ["paginationTime"]=> float(0.057106971740723) } }

20km:
array(3) { ["buildQueryTime"]=> float(0.20179200172424) [0]=> array(1) { ["FindTime"]=> float(4.9068400859833) } [1]=> array(1) { ["paginationTime"]=> float(0.052983999252319) } }

30km:
array(3) { ["buildQueryTime"]=> float(0.14019298553467) [0]=> array(1) { ["FindTime"]=> float(7.6637330055237) } [1]=> array(1) { ["paginationTime"]=> float(0.034801959991455) } }

40 km:
{ ["buildQueryTime"]=> float(0.1900360584259) [0]=> array(1) { ["FindTime"]=> float(9.1062920093536) } [1]=> array(1) { ["paginationTime"]=> float(0.054894924163818) } }

Nombres maximum addresse 32
109303
## Recherche par coordonnées sur toutes les adresses:

10 km:
array(3) { ["buildQueryTime"]=> float(35.413099050522) [0]=> array(1) { ["FindTime"]=> float(56.901561975479) } [1]=> array(1) { ["paginationTime"]=> float(0.063422203063965) } }
20 km:

30 km:

40 km:

## Recherche par carré minmax:
 10km:  ["buildQueryTime"]=> float(0.2824809551239) [0]=> array(1) { ["FindTime"]=> float(18.662551164627) } [1]=> array(1) { ["paginationTime"]=> float(0.063510179519653) } } array(3) { ["buildQueryTime"]=> float(0.0094559192657471) [0]=> array(1) { ["FindTime"]=> float(18.775280952454) } [1]=> array(1) { ["paginationTime"]=> float(0.2626678943634)

 40km: ["buildQueryTime"]=> float(0.26057291030884) [0]=> array(1) { ["FindTime"]=> float(32.927497148514) } [1]=> array(1) { ["paginationTime"]=> float(0.064902067184448) } } array(3) { ["buildQueryTime"]=> float(0.00913405418396) [0]=> array(1) { ["FindTime"]=> float(16.537523031235) } [1]=> array(1) { ["paginationTime"]=> float(1.1827399730682)

