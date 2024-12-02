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
     * Mthode permettant l'ajout d'un utilisateur
     */
    public function addUser($pseudo, $password, $admin){
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // requete sql permettant d'ajouter un utilisateur
        $query = "INSERT INTO t_utilisateur (pseudo, password, admin, date_entree)
        VALUES (:pseudo, :password, :admin, :date_entree)";

        $date = date("d/m/y");

        $binds = [
            'pseudo' => $pseudo,
            'password' => $hashedPassword,
            'admin' => $admin,
            'date_entree' => $date,
        ];

        $this->queryPrepareExecute($query, $binds);
    }

    /**
     * Methode permettant de récupèrer un utilisateur spécifique par son login
     */
    public function getUserByLogin($login){
        $query = "SELECT * FROM t_utilisateur WHERE pseudo = :pseudo";
        $stmt = $this->queryPrepareExecute($query, ['pseudo' => $login]);
        $users = $this->formatData($stmt);
        return count($users) === 1 ? $users[0] : [];
    }

    /**
     * Methode permettant de retourner tout les utilisateurs
     */
    public function getAllUsers(){
        // requete sql selectionnant toute la table t_user
        $query = "SELECT * FROM t_utilisateur";

        //execute la requete sql
        return $this->formatData($this->querySimpleExecute($query));
    }


    /**
     * Methode permettant de retourner tout les livres pour une catégorie
     */
    public function getBooksByCategory($category){
        // requete sql selectionnant tout les livres d'une catégorie
         $query = "SELECT 
        t_ouvrage.image AS photo_du_livre,
        t_ouvrage.titre AS nom_du_livre,
        CONCAT(t_auteur.prenom, ' ', t_auteur.nom) AS nom_de_l_auteur,
        t_utilisateur.pseudo AS pseudo_ajouteur
        FROM 
            t_ouvrage
        INNER JOIN 
            t_auteur ON t_ouvrage.auteur_id = t_auteur.auteur_id
        INNER JOIN 
            t_utilisateur ON t_ouvrage.utilisateur_id = t_utilisateur.utilisateur_id
        INNER JOIN 
            t_categorie ON t_ouvrage.categorie_id = t_categorie.categorie_id
        WHERE 
            t_categorie.nom = '$category'";

        // retourne le résultat ous forme de tableau
        return $this->formatData($this->querySimpleExecute($query));
    }

    /**
     * Methode permettant de retourner tout les livres pour une catégorie
     */
    public function getAllCategory(){
        // requete sql selectionnant tout les livres d'une catégorie
         $query = "SELECT * from t_categorie";

         //retourne le résultat de la requete sous forme de tableau
         return $this->formatData($this->querySimpleExecute($query));
    }
}
?>