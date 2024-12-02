<?php
/**
 * ETML
 * Auteur : Dany Carneiro, Maxime Pelloquin, Yann Scerri, Hanieh Mohajerani
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

// Récupérer un utilisateur par son ID
public function getUserById($userId) {
    $query = "
        SELECT 
            pseudo, 
            (SELECT COUNT(*) FROM apprecier WHERE utilisateur_id = :id) AS review_count,
            (SELECT COUNT(*) FROM t_ouvrage WHERE utilisateur_id = :id) AS upload_count
        FROM t_utilisateur
        WHERE utilisateur_id = :id
    ";
    $result = $this->queryPrepareExecute($query, ['id' => $userId]);
    return $result->fetch(PDO::FETCH_ASSOC);
}


// Mettre à jour le pseudo d'un utilisateur
public function updateUserPseudo($userId, $newPseudo) {
    $query = "
        UPDATE t_utilisateur
        SET pseudo = :pseudo
        WHERE utilisateur_id = :id
    ";
    return $this->queryPrepareExecute($query, ['pseudo' => $newPseudo, 'id' => $userId]);
}

//Récupérer les livres ajoutés par l'utilisateur
public function getBooksUploadedByUser($userId) {
    $query = "
        SELECT titre, extrait, resume, annee, image, nombre_pages 
        FROM t_ouvrage 
        WHERE utilisateur_id = :id
    ";
    $req = $this->queryPrepareExecute($query, ['id' => $userId]);
    return $this->formatData($req); // Retourne les résultats sous forme de tableau associatif
}

//Récupérer les livres notés par l'utilisateur
public function getBooksRatedByUser($userId) {
    $query = "
        SELECT o.titre, o.image, a.note 
        FROM apprecier a
        INNER JOIN t_ouvrage o ON a.ouvrage_id = o.ouvrage_id
        WHERE a.utilisateur_id = :id
    ";
    $req = $this->queryPrepareExecute($query, ['id' => $userId]);
    return $this->formatData($req); // Retourne les résultats sous forme de tableau associatif
}


   
}
