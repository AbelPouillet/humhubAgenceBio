<?php

namespace humhub\modules\cet_entite\models;

use humhub\modules\cet_join_infos_supplementaires_entite\models\Joininfossupplementairesentite;
use humhub\modules\cet_infos_supplementaires\models\Infossupplementaires;
use humhub\modules\cet_entite\models\Entite;
use humhub\modules\cet_infos_supplementaires_valeur\models\Infossupplementairesvaleur;

use Yii;
use yii\base\Model;

class AdminForm extends Model
{
    public Entite $entite;

    public int $entiteId;
    public string $nomDusage;
    public string $adresse;
    public string $telephone;
    public string $email;
    public string $siteweb;
    public function attributeLabels()
    {
        return [
            'nomDusage' => "Nom d'usage",
            'adresse' => "Adresse",
            'telephone' => "Telephone",
            'email' => "Email",
            'siteweb' => "Site Web"
        ];
    }
    public function initAdminForm()
    {
        $this->entite =  Entite::findOne(['id' => intVal($this->entiteId, 10)]);
        $this->nomDusage = $this->getNomDusage();
        $this->adresse = $this->getAdresse();
        $this->telephone = $this->getTelephone();
        $this->email = $this->getEmail();
        $this->siteweb = $this->getSiteweb();
    }
    public function getNomDusage()
    {
        $nomDusage = "";
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admNomDusage"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admNomDusage") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $nomDusage = $infossupplementaireValeur->valeur;
            } else {
                $nomDusage = $this->entite->denominationcourante ? $this->entite->denominationcourante : "";
            }
        } else {
            $nomDusage = $this->entite->denominationcourante ? $this->entite->denominationcourante : "";
        }
        return $nomDusage;
    }
    public function setNomDusage($newNomDusage)
    {
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admNomDusage"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admNomDusage") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newNomDusage;
                $infossupplementaireValeur->save(false);
                Yii::$app->search->update($this->entite);
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newNomDusage;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                    Yii::$app->search->update($this->entite);
                }
            }
        } else {
            $newInfossupplementaire = new Infossupplementaires();
            $newInfossupplementaire->id = Infossupplementaires::find()->max('id') + 1;
            $newInfossupplementaire->nom = "admNomDusage";
            $newInfossupplementaire->label = "Nom d'usage";
            $newInfossupplementaire->save(false);
            $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
            $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
            $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $newInfossupplementaire->id;
            $newJoinInfosupplementaireEntite->save(false);
            $newInfossupplementaireValeur = new Infossupplementairesvaleur();
            $newInfossupplementaireValeur->valeur = $newNomDusage;
            $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
            $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $newInfossupplementaire->id;
            if ($newInfossupplementaireValeur->save(false)) {
                Yii::$app->search->update($this->entite);
            }
        }
        $this->nomDusage = $newNomDusage;
    }
    public function getAdresse()
    {
        $Adresse = "";
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admAdresse"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admAdresse") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $Adresse = $infossupplementaireValeur->valeur;
            } else {
                $Adresse = $this->entite->adresses[0]->getAdresseSTR() ? $this->entite->adresses[0]->getAdresseSTR() : "";
            }
        } else {
            $Adresse = $this->entite->adresses[0]->getAdresseSTR() ? $this->entite->adresses[0]->getAdresseSTR() : "";
        }
        return $Adresse;
    }
    public function setAdresse($newAdresse)
    {
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admnewAdresse"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admnewAdresse") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newAdresse;
                $infossupplementaireValeur->save(false);
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newAdresse;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $newInfossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                }
            }
        } else {
            $newInfossupplementaire = new Infossupplementaires();
            $newInfossupplementaire->id = Infossupplementaires::find()->max('id') + 1;
            $newInfossupplementaire->nom = "admnewAdresse";
            $newInfossupplementaire->label = "Adresse";
            $newInfossupplementaire->save(false);
            $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
            $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
            $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $newInfossupplementaire->id;
            $newJoinInfosupplementaireEntite->save(false);
            $newInfossupplementaireValeur = new Infossupplementairesvaleur();
            $newInfossupplementaireValeur->valeur = $newAdresse;
            $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
            $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $newInfossupplementaire->id;
            if ($newInfossupplementaireValeur->save(false)) {
            }
        }
        $this->adresse = $newAdresse;
    }
    public function getTelephone()
    {
        $telephone = "";
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admTelephone"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admTelephone") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $telephone = $infossupplementaireValeur->valeur;
            } else {
                $telephone = $this->entite->telephone ? $this->entite->telephone : "";
            }
        } else {
            $telephone = $this->entite->telephone ? $this->entite->telephone : "";
        }
        return $telephone;
    }
    public function setTelephone($newTelephone)
    {
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admTelephone"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admTelephone") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newTelephone;
                $infossupplementaireValeur->save(false);
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newTelephone;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                }
            }
        } else {
            $newInfossupplementaire = new Infossupplementaires();
            $newInfossupplementaire->id = Infossupplementaires::find()->max('id') + 1;
            $newInfossupplementaire->nom = "admTelephone";
            $newInfossupplementaire->label = "Téléphone";
            $newInfossupplementaire->save(false);
            $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
            $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
            $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $newInfossupplementaire->id;
            $newJoinInfosupplementaireEntite->save(false);
            $newInfossupplementaireValeur = new Infossupplementairesvaleur();
            $newInfossupplementaireValeur->valeur = $newTelephone;
            $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
            $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $newInfossupplementaire->id;
            if ($newInfossupplementaireValeur->save(false)) {
            }
        }
        $this->telephone = $newTelephone;
    }
    public function getEmail()
    {
        $email = "";
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admEmail"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admEmail") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $email = $infossupplementaireValeur->valeur;
            } else {
                $email = $this->entite->email ? $this->entite->email : "";
            }
        } else {
            $email = $this->entite->email ? $this->entite->email : "";
            //print("on get info supp vide");
        }
        return $email;
    }
    public function setEmail($newEmail)
    {

        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admEmail"]);
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admEmail") {
            $infossupplementaireValeur = Infossupplementairesvaleur::findOne(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id]);
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newEmail;
                //print($infossupplementaireValeur->valeur);
                if ($infossupplementaireValeur->save(false)) {
                    //print("Save normalement réussi : ".var_dump($infossupplementaireValeur));
                }else{
                    //print($infossupplementaireValeur->valeur);
                }
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newEmail;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                }
            }
        } else {
            $newInfossupplementaire = new Infossupplementaires();
            $newInfossupplementaire->id = Infossupplementaires::find()->max('id') + 1;
            $newInfossupplementaire->nom = "admEmail";
            $newInfossupplementaire->label = "Email";
            if ($newInfossupplementaire->save(false)) {
                $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
                $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
                $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $newInfossupplementaire->id;
                if ($newJoinInfosupplementaireEntite->save(false)) {
                    $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                    $newInfossupplementaireValeur->valeur = $newEmail;
                    $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                    $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $newInfossupplementaire->id;
                    if ($newInfossupplementaireValeur->save(false)) {
                    }
                }
            }
            //print('on passe la pour create');
        }
        $this->email = $newEmail;
    }
    public function getSiteweb()
    {
        $siteweb = "";
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admSiteWeb"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admSiteWeb") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $siteweb = $infossupplementaireValeur->valeur;
            } else {
                $siteweb = $this->entite->sitewebs[0]->url ? $this->entite->sitewebs[0]->url : "";
            }
        } else {
            $siteweb = $this->entite->sitewebs[0]->url ? $this->entite->sitewebs[0]->url : "";
        }
        return $siteweb;
    }
    public function setSiteweb($newSiteWeb)
    {
        $infossupplementaire = $this->entite->getInfossupplementaires()->andWhere(["nom" => "admSiteWeb"])->one();
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admSiteWeb") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newSiteWeb;
                $infossupplementaireValeur->save(false);
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newSiteWeb;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
            }
        } else {
            $newInfossupplementaire = new Infossupplementaires();
            $newInfossupplementaire->id = Infossupplementaires::find()->max('id') + 1;
            $newInfossupplementaire->nom = "admSiteWeb";
            $newInfossupplementaire->label = "Site Web";
            $newInfossupplementaire->save(false);
            $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
            $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
            $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $newInfossupplementaire->id;
            $newJoinInfosupplementaireEntite->save(false);
            $newInfossupplementaireValeur = new Infossupplementairesvaleur();
            $newInfossupplementaireValeur->valeur = $newSiteWeb;
            $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
            $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $newInfossupplementaire->id;
            if ($newInfossupplementaireValeur->save(false)) {
            }
        }
        $this->siteweb = $newSiteWeb;
    }
}
