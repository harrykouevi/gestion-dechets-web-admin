<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class StatService
{
    use ServiceTrait;


    /**
     * Récupère un post par son ID, avec ou sans relations.
     *
     * @return array
     * @throws \Exception
     * /collecteur/count'
     */
    public function getDomicilleCount() : int
    {
        $params = [];

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/domicile/count', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }

    /**
     * Récupère un post par son ID, avec ou sans relations.
     *
     * @return array
     * @throws \Exception
     * '
     */
    public function getAgentCount() : int
    {
        $params = [];

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/collecteur/count', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }


     /**
     * Récupère un post par son ID, avec ou sans relations.
     *
     * @return int
     * @throws \Exception
     */
    public function getQuizzParticipantCount() : int
    {
        $params = [];

        if (!empty($relations)) {
            $params['with_relations'] = 'true';
        }

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/quizz-participant/count', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }

    /**
     * Récupère un post par son ID, avec ou sans relations.
     *
     * @return array
     * @throws \Exception
     */
    public function getPostMostRead() : array
    {
        $params = [];

        if (!empty($relations)) {
            $params['with_relations'] = 'true';
        }

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/post-most-read', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }


    


     /**
     * Récupère le taux de reussite aux  quiz.
     *
     * Options possibles :
     * - quizId (int|null)      : L'ID du quiz concerné
     * - dateDebut (Carbon|null): Date de début pour filtrer les tentatives
     * - dateFin (Carbon|null)  : Date de fin pour filtrer les tentatives
     *
     * @param array $options
     * @return float|int
     * @throws \Exception
     */
    public function getQuizzSuccessRate(array $options = [])
    {
        $params = [];
        // Valeurs par défaut
        $params['quizId'] = $options['quizId'] ?? null;
        $params['dateDebut'] = $options['dateDebut'] ?? null;
        $params['dateFin'] = $options['dateFin'] ?? null;

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/quizz-success-rate', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }

    /**
     * Calcule la moyenne de score au quiz.
     *
     * Options possibles :
     * - quizId (int|null)      : L'ID du quiz concerné
     * - dateDebut (Carbon|null): Date de début pour filtrer les tentatives
     * - dateFin (Carbon|null)  : Date de fin pour filtrer les tentatives
     *
     * @param array $options
     * @return float|int
     * @throws \Exception
     */
    public function getQuizzScoreRate(array $options = [])
    {
        $params = [];
        // Valeurs par défaut
        $params['quizId'] = $options['quizId'] ?? null;
        $params['dateDebut'] = $options['dateDebut'] ?? null;
        $params['dateFin'] = $options['dateFin'] ?? null;

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/quizz-score-rate', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }

    /**
     * Calcule meilleurs scores au quiz.
     *
     * Options possibles :
     * - quizId (int|null)      : L'ID du quiz concerné
     * - dateDebut (Carbon|null): Date de début pour filtrer les tentatives
     * - dateFin (Carbon|null)  : Date de fin pour filtrer les tentatives
     *
     * @param array $options
     * @return float|int
     * @throws \Exception
     */
    public function getQuizzTopScore(array $options = [])
    {
        $params = [];
        // Valeurs par défaut
        $params['perPage'] = $options['perPage'] ?? null;

        $response = Http::withToken(session('token'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get(env('API_SERVICE_URL') . '/api/statistiques/quizz-top-scores', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception('Erreur lors de la récupération du post');
    }

  
}
