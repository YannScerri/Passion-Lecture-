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
public function getOneOuvrage($idOuvrage) {
    // Requête SQL pour récupérer les détails d'un livre spécifique par son ID
    $query = "
        SELECT t_ouvrage.*, 
               t_auteur.nom AS auteur_nom, 
               t_auteur.prenom AS auteur_prenom, 
               t_editeur.nom AS editeur_nom, 
               t_categorie.nom AS categorie_nom
        FROM t_ouvrage
        JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
        JOIN t_editeur ON t_ouvrage.editeur_id = t_editeur.editeur_id
        JOIN t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
        WHERE t_ouvrage.ouvrage_id = :ouvrage_id
    ";

    // Préparer et exécuter la requête
    $req = $this->queryPrepareExecute($query, ["ouvrage_id" => $idOuvrage]);

    // Récupérer un seul résultat (fetch au lieu de fetchAll pour éviter un tableau d'objets)
    $ouvrage = $req->fetch(PDO::FETCH_ASSOC);

    // Retourner les résultats ou null si non trouvé
    return $ouvrage ?: null;
}


public function getOneCategorie($idCategorie){

      
    // Requête pour récupérer un enseignant spécifique par son ID
    $query = "SELECT * FROM t_categorie WHERE categorie_id = :categorie_id";

    $binds = [];
    $binds[":categorie_id"] = $idCategorie; 

    $req = $this->queryPrepareExecute($query, $binds);
   

    // Retourner les résultats sous forme de tableau associatif
    $categorie = $this->formatData($req);
    
    // Retourner les informations de l'enseignant
    return $categorie[0];
}

//admin
public function getAllOuvrages() {
    // Requête SQL pour récupérer tous les livres
    $query = "
        SELECT t_ouvrage.*, t_auteur.nom AS auteur_nom, t_auteur.prenom AS auteur_prenom, 
               t_editeur.nom AS editeur_nom, t_categorie.nom AS categorie_nom
        FROM t_ouvrage
        JOIN t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
        JOIN t_editeur ON t_ouvrage.editeur_id = t_editeur.editeur_id
        JOIN t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
    ";

    // Exécution de la requête préparée
    $req = $this->querySimpleExecute($query);

    // On formate les résultats en tableau associatif
    $ouvrages = $this->formatData($req);

    return $ouvrages;
}


}



?>