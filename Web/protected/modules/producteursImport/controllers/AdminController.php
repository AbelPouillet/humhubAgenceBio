<?php
namespace humhub\modules\producteursImport\controllers;

use humhub\modules\admin\components\Controller;
use mysqli;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Profile;

class AdminController extends Controller
{

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index', [
            'res' => false,
            'cptAction' => 0,
        ]);
    }

    public function actionImport($cptAction) {

        // on se connecte à la base MySQL
        $db = new mysqli('cetcal_db', 'user', 'user', 'cetcal');
        // on crée la requête SQL
        $sql = 'SELECT nom,prenom,email,adrferme_numvoie,adrferme_rue,adrferme_lieudit,adrferme_commune,adrferme_cp,adrferme_compladr,nom_ferme,prod_active FROM cetcal_producteur';
        // on envoie la requête
        $req = mysqli_query($db, $sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysqli_error($db));
        //On initialise la réponse
        $cptAction ++;
        $res = 'Import : <br/>';
        $cpt = 0;
        $cptSuccess = 0;
        // on fait une boucle qui va faire un tour pour chaque enregistrement
        $data = mysqli_fetch_all($req);
        foreach ($data as $raw){
            if ($raw[10] > 0) {
                $cpt++;
                $newHumhubProducteur = new User();
                //$encoding = mb_detect_encoding($raw['nom_ferme']);
                $newHumhubProducteur->username = $raw[2];
                $newHumhubProducteur->email = $raw[2];
                $newHumhubProducteur->status = User::STATUS_ENABLED;
                $newHumhubProducteur->scenario = 'editAdmin';

                if ($newHumhubProducteur->save()) {

                    #Pour avoir l'id dans l'objet user
                    $newHumhubProducteur = User::findOne(['email' => $raw[2]]);
                    if ($newHumhubProducteur) {
                        isset($raw[4]) ? $newHumhubProducteur->profile->street = iconv("ISO-8859-1", "UTF-8", $raw[4]) : $newHumhubProducteur->profile->street = "undefined";
                        isset($raw[7]) ? $newHumhubProducteur->profile->city = iconv("ISO-8859-1", "UTF-8", $raw[7]) : $newHumhubProducteur->profile->city = "undefined";
                        isset($raw[8]) ? $newHumhubProducteur->profile->zip = iconv("ISO-8859-1", "UTF-8", $raw[8]) : $newHumhubProducteur->profile->zip = "undefined";
                        isset($raw[1]) ? $newHumhubProducteur->profile->firstname = iconv("ISO-8859-1", "UTF-8", $raw[1]) : $newHumhubProducteur->profile->firstname = "undefined";
                        if (!$newHumhubProducteur->profile->firstname) {
                            $newHumhubProducteur->profile->firstname = 'prenom';
                        }
                        isset($raw[0]) ? $newHumhubProducteur->profile->lastname = iconv("ISO-8859-1", "UTF-8", $raw[0]) : $newHumhubProducteur->profile->lastname = "";

                        if (!$newHumhubProducteur->profile->lastname) {
                            isset($raw[9]) ? $newHumhubProducteur->profile->lastname = iconv("ISO-8859-1", "UTF-8", $raw[9]) : $newHumhubProducteur->profile->lastname = "undefined";
                        }
                        $newHumhubProducteur->profile->country = 'FR';
                        $newHumhubProducteur->profile->scenario = Profile::SCENARIO_EDIT_PROFILE;
                        if (!$newHumhubProducteur->profile->save()) {
                            $errors = $newHumhubProducteur->profile->getErrors();
                            foreach ($errors as $error) {
                                if (isset($raw[0]) && isset($raw[1])) {
                                    $res = $res . iconv("ISO-8859-1", "UTF-8", $raw[0]) . ' ' . iconv("ISO-8859-1", "UTF-8", $raw[1]) . $error[0] . ' en erreur profile <br/>';
                                }
                                else {
                                    $res = $res . " Unamed Error " . $error[0] . ' en erreur user <br/>';
                                }
                            }
                            $newHumhubProducteur->delete();
                        }
                        else {
                            // on affiche l'enregistrement en cours
                            $cptSuccess++;
                            if (isset($raw[0]) && isset($raw[1])) {
                                $res = $res . '<b>' . iconv("ISO-8859-1", "UTF-8", $raw[0]) . ' ' . iconv("ISO-8859-1", "UTF-8", $raw[1]) . '</b> (email :' . iconv("ISO-8859-1", "UTF-8", $raw[2]) . ') Enregister avec succé';
                            }
                            else {
                                $res = $res . ' Unamed Registered  <br/>';
                            }
                        }

                    }
                    else {
                        return iconv("ISO-8859-1", "UTF-8", $raw[0]) . ' ' . iconv("ISO-8859-1", "UTF-8", $raw[1] . ' saved but not found');
                    }
                }
                else {
                    $errors = $newHumhubProducteur->getErrors();
                    foreach ($errors as $error) {
                        if (isset($raw[0]) && isset($raw[1])) {
                            $res = $res . iconv("ISO-8859-1", "UTF-8", $raw[0]) . ' ' . iconv("ISO-8859-1", "UTF-8", $raw[1]) . $error[0] . ' en erreur user <br/>';
                        }
                        else {
                            $res = $res . " Unamed Error " . $error[0] . ' en erreur user <br/>';
                        }
                    }
                }

            }
            else {
                $res = $res . iconv("ISO-8859-1", "UTF-8", $raw[0]) . ' ' . iconv("ISO-8859-1", "UTF-8", $raw[1]) . ' Producteur inactif (supprimer) <br/>';
            }
        }
        /*
        while ($data = mysqli_fetch_assoc($req)) {
            if ($data['prod_active'] > 0) {
                $cpt++;
                $newHumhubProducteur = new User();
                //$encoding = mb_detect_encoding($data['nom_ferme']);
                $newHumhubProducteur->username = $data['email'];
                $newHumhubProducteur->email = $data['email'];
                $newHumhubProducteur->status = User::STATUS_ENABLED;
                $newHumhubProducteur->scenario = 'editAdmin';

                if ($newHumhubProducteur->save()) {

                    #Pour avoir l'id dans l'objet user
                    $newHumhubProducteur = User::findOne(['email' => $data['email']]);
                    if ($newHumhubProducteur) {
                        isset($data['adrferme_rue']) ? $newHumhubProducteur->profile->street = iconv("ISO-8859-1", "UTF-8", $data['adrferme_rue']) : $newHumhubProducteur->profile->street = "undefined";
                        isset($data['adrferme_commune']) ? $newHumhubProducteur->profile->city = iconv("ISO-8859-1", "UTF-8", $data['adrferme_commune']) : $newHumhubProducteur->profile->city = "undefined";
                        isset($data['adrferme_cp']) ? $newHumhubProducteur->profile->zip = iconv("ISO-8859-1", "UTF-8", $data['adrferme_cp']) : $newHumhubProducteur->profile->zip = "undefined";
                        isset($data['prenom']) ? $newHumhubProducteur->profile->firstname = iconv("ISO-8859-1", "UTF-8", $data['prenom']) : $newHumhubProducteur->profile->firstname = "undefined";
                        if (!$newHumhubProducteur->profile->firstname) {
                            $newHumhubProducteur->profile->firstname = 'prenom';
                        }
                        isset($data['nom']) ? $newHumhubProducteur->profile->lastname = iconv("ISO-8859-1", "UTF-8", $data['nom']) : $newHumhubProducteur->profile->lastname = "";

                        if (!$newHumhubProducteur->profile->lastname) {
                            isset($data['nom_ferme']) ? $newHumhubProducteur->profile->lastname = iconv("ISO-8859-1", "UTF-8", $data['nom_ferme']) : $newHumhubProducteur->profile->lastname = "undefined";
                        }
                        $newHumhubProducteur->profile->country = 'FR';
                        $newHumhubProducteur->profile->scenario = Profile::SCENARIO_EDIT_PROFILE;
                        if (!$newHumhubProducteur->profile->save()) {
                            $errors = $newHumhubProducteur->profile->getErrors();
                            foreach ($errors as $error) {
                                if (isset($data['nom']) && isset($data['prenom'])) {
                                    $res = $res . iconv("ISO-8859-1", "UTF-8", $data['nom']) . ' ' . iconv("ISO-8859-1", "UTF-8", $data['prenom']) . $error[0] . ' en erreur profile <br/>';
                                }
                                else {
                                    $res = $res . " Unamed Error " . $error[0] . ' en erreur user <br/>';
                                }
                            }
                            $newHumhubProducteur->delete();
                        }
                        else {
                            // on affiche l'enregistrement en cours
                            $cptSuccess++;
                            if (isset($data['nom']) && isset($data['prenom'])) {
                                $res = $res . '<b>' . iconv("ISO-8859-1", "UTF-8", $data['nom']) . ' ' . iconv("ISO-8859-1", "UTF-8", $data['prenom']) . '</b> (email :' . iconv("ISO-8859-1", "UTF-8", $data['email']) . ') Enregister avec succé';
                            }
                            else {
                                $res = $res . ' Unamed Registered  <br/>';
                            }
                        }

                    }
                    else {
                        return iconv("ISO-8859-1", "UTF-8", $data['nom']) . ' ' . iconv("ISO-8859-1", "UTF-8", $data['prenom'] . ' saved but not found');
                    }
                }
                else {
                    $errors = $newHumhubProducteur->getErrors();
                    foreach ($errors as $error) {
                        if (isset($data['nom']) && isset($data['prenom'])) {
                            $res = $res . iconv("ISO-8859-1", "UTF-8", $data['nom']) . ' ' . iconv("ISO-8859-1", "UTF-8", $data['prenom']) . $error[0] . ' en erreur user <br/>';
                        }
                        else {
                            $res = $res . " Unamed Error " . $error[0] . ' en erreur user <br/>';
                        }
                    }
                }

            }
            else {
                $res = $res . iconv("ISO-8859-1", "UTF-8", $data['nom']) . ' ' . iconv("ISO-8859-1", "UTF-8", $data['prenom']) . ' Producteur inactif (supprimer) <br/>';
            }

        }*/
        // on ferme la connexion à mysql
        mysqli_close($db);

        $res = $cptSuccess . ' sur ' . $cpt . 'Enregister avec Succées <br/>' . $res;

        return $this->render('index', [
            'res' => $res,
            'cptAction' => $cptAction,
        ]);
    }

}
