<?php 
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : fichier contenant la classe database qui permet de récupérer et d'utiliser les données dans la base de données 
 */


class Database{

    // Variable de classe
    private $connector;

    public function __construct()
    {
        try
        {
            // Lire le fichier de config json
            $json = file_get_contents('../json/config.json');

            // Charger la configuration depuis le fichier JSON
            $config = json_decode($json, true);

            // Construire la chaîne de connexion
            $dsn = 'mysql:host=' . $config['database']['host'] . 
                   ';port=' . $config['database']['port'] . 
                   ';dbname=' . $config['database']['dbname'] . 
                   ';charset=' . $config['database']['charset'];

            // Se connecter à la base de données
            $this->connector = new PDO($dsn, $config['database']['username'], $config['database']['password']);
        }
        catch (PDOException $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Methode permettant d'executer une simple requete sql
     */
    private function querySimpleExecute($query){

        // Effectue une simple requete
        $req = $this->connector->query($query);
        return $req;
    }

    /**
     * Methode permettant d'executer une simple requete sql en utilisant "prepare"
     */
    private function queryPrepareExecute($query, $binds = []){
        $req = $this->connector->prepare($query);

        foreach ($binds as $key => $value) {
            // On utilise PDO::PARAM_STR par défaut, mais tu peux adapter en fonction des besoins
            $req->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
        $req->execute();
        return $req;
    }

    /**
     * TODO: à compléter
     */
    private function formatData($req){

        // traitement des données pour les retourner par exemple en tableau associatif (avec PDO::FETCH_ASSOC)
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * TODO: à compléter
     */
    private function unsetData($req){
        // TODO: vider le jeu d’enregistrement
        $req->closeCursor();
    }

    /**
 * Récupère les informations d'un ouvrage spécifique par ID.
 * @param int $id L'identifiant de l'ouvrage
 * @return array Les informations de l'ouvrage
 */
public function getOneOuvrage($id) {
    // Requête SQL pour récupérer les détails d'un livre spécifique par son ID
    $query = "
            SELECT t_ouvrage.*, t_auteur.nom, t_auteur.prenom, t_editeur.nom, t_categorie.nom
        FROM t_ouvrage
        JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
        JOIN t_editeur ON t_ouvrage.editeur_id = t_editeur.editeur_id
        JOIN t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
        WHERE t_ouvrage.ouvrage_id = :idOuvrage

    ";

    // On prépare les variables à lier à la requête
    $binds = [];
    $binds[":idOuvrage"] = $id;

    // Exécution de la requête préparée
    $req = $this->queryPrepareExecute($query, $binds);

    // On formate les résultats en tableau associatif
    $ouvrage = $this->formatData($req);

    // Retourner le premier résultat (en général un seul livre correspond à un ID)
    return $ouvrage[0];
}

}


?>