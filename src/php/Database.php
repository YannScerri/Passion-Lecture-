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
     * formatte les données reçues par une requête en tableau associatif
     */
    private function formatData($req){

        // traitement des données pour les retourner par exemple en tableau associatif (avec PDO::FETCH_ASSOC)
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * récupère les 5 derniers livres ajoutés
     */
    public function get5LastBooks(){

        $query = "SELECT titre, image, pseudo, nom, prenom FROM t_ouvrage INNER JOIN t_auteur ON t_ouvrage.auteur_id = t_auter.auteur_id INNER JOIN t_utilisateur ON t_utilisateur.utilisateur_id = t_ouvrage.utilisateur_id ORDER BY ouvrage_id DESC LIMIT 5";

        return $this->formatData($this->querySimpleExecute($query));
    }
}
?>