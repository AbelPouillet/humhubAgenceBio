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

    public $tags = [];

    public function attributeLabels()
    {
        return [
            'nomDusage' => "Nom d'usage",
            'adresse' => "Adresse",
            'telephone' => "Telephone",
            'email' => "Email",
            'siteweb' => "Site Web",
            'tags' => 'Etiquettes'
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
        $this->tags = $this->entite->getEntiteTags()->all();
    }

    public function setTags($tags)
    {
        EntiteTag::attach($this->entite, $tags);
    }
    public function getNomDusage()
    {
        $nomDusage = "";
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admNomDusage"]);
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
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admNomDusage"]);
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admNomDusage") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newNomDusage;
                $infossupplementaireValeur->save(false);
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newNomDusage;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                    $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
                    $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
                    $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $infossupplementaire->id;
                    $newJoinInfosupplementaireEntite->save(false);
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
            }
        }
        $this->nomDusage = $newNomDusage;
    }
    public function getAdresse()
    {
        $Adresse = "";
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admAdresse"]);
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
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admnewAdresse"]);
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
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                    $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
                    $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
                    $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $infossupplementaire->id;
                    $newJoinInfosupplementaireEntite->save(false);
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
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admTelephone"]);
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
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admTelephone"]);
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
                    $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
                    $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
                    $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $infossupplementaire->id;
                    $newJoinInfosupplementaireEntite->save(false);
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
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admEmail"]);
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admEmail") {
            $infossupplementaireValeur = $infossupplementaire->getInfossupplementairesValeurs()
                ->andWhere(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id])->one();
            if ($infossupplementaireValeur) {
                //print("on passe la valeur existante");
                $email = $infossupplementaireValeur->valeur;
            } else {
                //print("on passe la valeur de l'entite");
                $email = $this->entite->email ? $this->entite->email : "";
            }
        } else {
            //print("on passe la valeur de l'entite car l'infosupp n'a pas été trouvé");
            $email = $this->entite->email ? $this->entite->email : "";
            //print("on get info supp vide");
        }
        return $email;
    }
    public function setEmail($newEmail)
    {

        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admEmail"]);
        //si infossupplementaire email existe
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admEmail") {
            $infossupplementaireValeur = Infossupplementairesvaleur::findOne(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id]);
            //Si la valeur de l'infos supplémentaire existe
            if ($infossupplementaireValeur) {
                //On update
                $infossupplementaireValeur->valeur = $newEmail;
                //print($infossupplementaireValeur->valeur);
                if ($infossupplementaireValeur->save(false)) {
                    //print("Save normalement réussi : ".var_dump($infossupplementaireValeur));
                } else {
                    //print($infossupplementaireValeur->valeur);
                }
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newEmail;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                if ($newInfossupplementaireValeur->save(false)) {
                    //print("Infos supplementaire email enregistrée");
                    $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
                    $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
                    $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $infossupplementaire->id;
                    $newJoinInfosupplementaireEntite->save(false);
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
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admSiteWeb"]);
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admSiteWeb") {
            //print("pk_cet_infos_supplementaires = " . $infossupplementaire->id . " entite id = " . $this->entite->id );
            $infossupplementaireValeur = Infossupplementairesvaleur::findOne(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id]);
            //print(var_dump($infossupplementaireValeur));
            if ($infossupplementaireValeur) {
                //print('on attribut la valeur infosupp');
                $siteweb = $infossupplementaireValeur->valeur;
            } else {
                //print("on ne trouve pas la valeur on met l'ancien site web ou vide");
                $siteweb = isset($this->entite->sitewebs[0]->url) ? $this->entite->sitewebs[0]->url : "";
            }
        } else {
            //print("on ne trouve pas l'infosupp on met l'ancien site web ou vide");
            $siteweb = isset($this->entite->sitewebs[0]->url) ? $this->entite->sitewebs[0]->url : "";
        }
        return $siteweb;
    }
    public function setSiteweb($newSiteWeb)
    {
        $infossupplementaire = Infossupplementaires::findOne(["nom" => "admSiteWeb"]);
        if (isset($infossupplementaire) && $infossupplementaire->nom == "admSiteWeb") {
            $infossupplementaireValeur = Infossupplementairesvaleur::findOne(["cet_entite_id" => $this->entite->id, "pk_cet_infos_supplementaires" => $infossupplementaire->id]);
            if ($infossupplementaireValeur) {
                $infossupplementaireValeur->valeur = $newSiteWeb;
                $infossupplementaireValeur->save(false);
            } else {
                $newInfossupplementaireValeur = new Infossupplementairesvaleur();
                $newInfossupplementaireValeur->valeur = $newSiteWeb;
                $newInfossupplementaireValeur->cet_entite_id = $this->entite->id;
                $newInfossupplementaireValeur->pk_cet_infos_supplementaires = $infossupplementaire->id;
                $newInfossupplementaireValeur->save(false);
                $newJoinInfosupplementaireEntite = new Joininfossupplementairesentite();
                $newJoinInfosupplementaireEntite->cet_entite_id = $this->entite->id;
                $newJoinInfosupplementaireEntite->cet_infos_supplementaires_id = $infossupplementaire->id;
                $newJoinInfosupplementaireEntite->save(false);
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
