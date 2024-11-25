<?php
/**
 * ETML
 * Auteur : Dany Carneiro
 * Date : 19.11.2024
 * Description : fichier contenant la classe database qui permet de récupérer et d'utiliser les données dans la base de données 
 */

class Database {

    // Variable de classe
    private $connector;

    public function __construct() {
        try {
            // Lire le fichier de config JSON
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
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Méthode permettant d'exécuter une simple requête SQL
     */
    private function querySimpleExecute($query) {
        $req = $this->connector->query($query);
        return $req;
    }

    /**
     * Méthode permettant d'exécuter une requête SQL avec "prepare"
     */
    private function queryPrepareExecute($query, $binds = []) {
        $req = $this->connector->prepare($query);

        foreach ($binds as $key => $value) {
            // Utilise PDO::PARAM_STR par défaut, adapte pour les entiers
            $req->bindValue(':' . $key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $req->execute();
        return $req;
    }

    /**
     * Méthode permettant de formater les données récupérées
     */
    private function formatData($req) {
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Méthode pour libérer les ressources d'une requête
     */
    private function unsetData($req) {
        $req->closeCursor();
    }

    /**
     * Méthode pour insérer un livre dans la table t_ouvrage
     */
    public function insertBook($data) {
        $query = "
            INSERT INTO t_ouvrage (titre, extrait, resume, annee, image, nombre_pages, utilisateur_id, categorie_id, editeur_id, auteur_id)
            VALUES (:titre, :extrait, :resume, :annee, :image, :nombre_pages, :utilisateur_id, :categorie_id, :editeur_id, :auteur_id)
        ";

        return $this->queryPrepareExecute($query, $data);
    }

    /**
 * Récupère toutes les catégories
 */
public function getAllCategories()
{
    $query = "SELECT * FROM t_categorie";
    $req = $this->querySimpleExecute($query);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les auteurs
 */
public function getAllAuthors()
{
    $query = "SELECT * FROM t_auteur";
    $req = $this->querySimpleExecute($query);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les éditeurs
 */
public function getAllEditors()
{
    $query = "SELECT * FROM t_editeur";
    $req = $this->querySimpleExecute($query);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}
   
}
